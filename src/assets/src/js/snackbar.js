/**
 * @copyright Copyright (c) 2024 neoacevedo
 * @subpackage yii2-material
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @class Snackbar
 * @extends HTMLElement
 * @description
 * `Snackbar` is a custom Web Component that displays brief messages to the user.
 * It supports auto-hiding after a specified duration and can include an optional close icon.
 *
 * @property {ShadowRoot} _shadowRoot - The shadow DOM root for the component.
 * @property {string|null} _showCloseIcon - Attribute to determine if a close icon should be shown. Its presence enables the icon.
 * @property {number} _duration - The duration (in seconds) for which the snackbar remains visible before auto-hiding. Defaults to 3 seconds.
 * @property {string|null} _autoHide - Attribute to control if the snackbar auto-hides. If present, auto-hide is disabled.
 * @property {HTMLElement} _snackbar - Reference to the main snackbar element within the shadow DOM.
 * @property {HTMLElement} _actions - Reference to the actions container within the shadow DOM.
 * @property {HTMLElement|null} _closeButton - Reference to the close button element if `_showCloseIcon` is set.
 */
class Snackbar extends HTMLElement {

    /**
     * @constructor
     * @description
     * Creates an instance of the Snackbar component.
     * Initializes the shadow DOM, sets default properties, and defines the internal structure and styling.
     */
    constructor() {
        super();
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._showCloseIcon = this.getAttribute('show-close-icon');
        this._duration = this.getAttribute('duration') ?? 3;
        this._autoHide = this.getAttribute('auto-hide');
        this._hideTimeout = null;
        this._shadowRoot.innerHTML = `
            <style>
                :host {
                    --md-icon-button-icon-color: var(--md-sys-color-inverse-on-surface);
                    --md-icon-button-hover-icon-color: var(--md-sys-color-inverse-on-surface);
                    --md-icon-button-focused-icon-color: var(--md-sys-color-inverse-on-surface);
                    --md-icon-button-hover-state-layer-color: var(--md-sys-color-inverse-primary);
                    --md-icon-button-focused-state-layer-color: var(--md-sys-color-inverse-primary);
                    --md-text-button-label-text-color: var(--md-sys-color-inverse-primary);
                    
                    font-family: 'Roboto';
                    font-size: 14px;
                    display:flex;flex-direction:column;z-index:999;
                }

                .snackbar {
                    display: none; /* Managed by JS, changes after transition */
                    opacity: 0;
                    visibility: hidden; /* Ensures it's not interactive when hidden */

                    position: fixed;
                    bottom: 20px; /* Final resting position from the bottom */
                    left: 50%;
                    transform: translateX(-50%) translateY(calc(100% + 20px)); /* Start below the screen, plus bottom offset */

                    background-color: var(--md-sys-color-inverse-surface);
                    color: var(--md-sys-color-inverse-on-surface);
                    border-radius: 4px;
                    min-width: 325px;
                    min-height: 48px;
                    max-height: 68px;
                    box-shadow: 0 2px 5px 0 var(--md-sys-color-shadow);
                    /* Transition for showing (opacity, transform) and hiding (opacity, transform, visibility) */
                    /* visibility transitions after other properties complete */
                    transition: opacity 0.3s ease-out, transform 0.3s ease-out, visibility 0s 0.3s;
                }

                .snackbar.show {
                    display: block;
                    opacity: 1;
                    visibility: visible;
                    transform: translateX(-50%) translateY(0); /* Final visible position */
                    /* During show, visibility changes instantly */
                    transition: opacity 0.3s ease-out, transform 0.3s ease-out;
                }

                .content {
                    display: flex;
                    flex-direction: row;
                    width: 100%; /* Ensure it takes full width of snackbar padding */
                }

                .actions {
                    display: flex;
                    align-items: center; /* Vertically center the button */
                    justify-content: flex-end; /* Align button to the right */
                    min-width: fit-content; /* Prevent button from shrinking too much */
                }

                ::slotted(div[slot="supporting-text"]) {
                    flex-grow: 1;
                    padding: 14px 16px;
                    white-space: normal; /* Allow text to wrap naturally */
                    overflow: hidden; /* Hide any overflow beyond 2 lines */
                    text-overflow: ellipsis; /* Add ellipsis for overflowing text (optional) */
                    line-height: 1.25rem;
                    font-weight: 400;
                }                
            </style>
            <div class="snackbar" id="snackbar">
                <md-elevation part="elevation" aria-hidden="true"></md-elevation>
                <div class="content">
                    <slot name="supporting-text"></slot>
                    <div id="actions" class="actions">
                        <slot name="action"></slot>
                    </div>
                </div>
            </div>
        `;
        this._snackbar = this._shadowRoot.getElementById('snackbar');
        this._actions = this._shadowRoot.getElementById('actions');

        /**
         * @method showSnackbar
         * @description
         * Public method to toggle the visibility of the snackbar.
         * If the `auto-hide` attribute is not present, the snackbar will automatically hide
         * after the duration specified by the `duration` attribute.
         */
        this.showSnackbar = this._showSnackbar.bind(this);

        /**
         * @method hide
         * @description
         * Public method to hide the snackbar.
         * When the `auto-hide` attribute is present, the snackbar will hide 
         * after calling this method.
         */
        this.hide = this._hide.bind(this);
    }

    /**
     * @private
     * @method _showSnackbar
     * @description
     * Internal method to handle the toggling of the 'show' class on the snackbar.
     * Manages the auto-hide timer based on the `_autoHide` property and `_duration`.
     */
    _showSnackbar = () => {
        // Clear any existing auto-hide timeout to prevent conflicts if showSnackbar is called again
        if (this._hideTimeout) {
            clearTimeout(this._hideTimeout);
            this._hideTimeout = null;
        }

        const isCurrentlyVisible = this._snackbar.classList.contains('show');

        if (isCurrentlyVisible) {
            // Snackbar is currently visible, so hide it (slide down)
            this._snackbar.classList.remove('show');
            // Set display to none AFTER the CSS transition completes (0.3s)
            this._hideTimeout = setTimeout(() => {
                this._snackbar.style.display = 'none';
            }, 300);
        } else {
            // Snackbar is currently hidden, so show it (slide up)
            this._snackbar.style.display = 'block'; // Ensure it's in the layout *before* animation starts

            // Use requestAnimationFrame to ensure 'display: block' is rendered
            // before 'show' class is added to trigger CSS transition.
            requestAnimationFrame(() => {
                this._snackbar.classList.add('show');
            });

            // Set auto-hide timeout if the 'auto-hide' attribute is NOT present
            if (this._autoHide === null) {
                this._hideTimeout = setTimeout(() => {
                    this._snackbar.classList.remove('show'); // Start fade-out and slide-down transition
                    // Set display to none AFTER the CSS transition completes (0.3s)
                    this._hideTimeout = setTimeout(() => {
                        this._snackbar.style.display = 'none';
                    }, 300);
                }, this._duration * 1000); // Duration for which snackbar remains fully visible
            }
        }
    }

    /**
     * @private
     * @method _hide
     * @description
     * Internal method to handle the 'show' class on the snackbar.
     * When it is called in a click event or after getting a response, the snackbar 
     * will be hidden.
     */
    _hide = () => {
        setTimeout(() => {
            this._snackbar.classList.toggle('show');
        }, 500); // wait for the transition to complete before hiding it completely
    }

    /**
     * @method connectedCallback
     * @description
     * Lifecycle callback that is invoked when the custom element is first connected to the document's DOM.
     * It checks for the `show-close-icon` attribute and, if present, adds a close button
     * and sets up its event listener to toggle the snackbar's visibility.
     */
    connectedCallback() {
        if (this._showCloseIcon !== null) {
            this._actions.innerHTML += `<md-icon-button id="closeButton"><md-icon>close</md-icon></md-icon-button>`;
            this._closeButton = this._shadowRoot.getElementById('closeButton');
            // Event listener for the close button
            this._closeButton.addEventListener('click', () => {
                // Clear any auto-hide timeout if user closes manually
                if (this._hideTimeout) {
                    clearTimeout(this._hideTimeout);
                    this._hideTimeout = null;
                }
                this._snackbar.classList.remove('show'); // Start fade-out and slide-down transition
                // Set display to none AFTER the CSS transition completes (0.3s)
                setTimeout(() => {
                    this._snackbar.style.display = 'none';
                }, 300);
            });
        }
    }

    /**
     * @method attributeChangedCallback
     * @description
     * Lifecycle callback that is invoked when one of the custom element's attributes is added, removed, or changed.
     * Currently, it responds to changes in the 'behavior' attribute to adjust the snackbar's positioning.
     * @param {string} name - The name of the attribute that changed.
     * @param {string} oldValue - The old value of the attribute.
     * @param {string} newValue - The new value of the attribute.
     */
    attributeChangedCallback(name, oldValue, newValue) {
        if (name === 'behavior') {
            const position = this.getAttribute('behavior');
            if (position === 'fixed') {
                this._snackbar.style.position = 'fixed';
            } else {
                this._snackbar.style.position = 'absolute';
            }
        }
    }
}

customElements.define('md-snackbar', Snackbar);
