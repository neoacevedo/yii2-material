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

class Snackbar extends HTMLElement {
    constructor() {
        super();
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._showCloseIcon = this.getAttribute('show-close-icon');
        this._duration = this.getAttribute('duration') ?? 3;
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
                    font-weight: 500;
                    display:flex;flex-direction:column;position:relative;z-index:0;
                }

                .snackbar {
                    display: none;
                    position: fixed;
                    bottom: 20px;
                    align-content: center;
                    left: 50%;
                    transform: translateX(-50%);
                    background-color: var(--md-sys-color-inverse-surface);
                    color: var(--md-sys-color-inverse-on-surface);
                    border-radius: 4px;
                    min-width: 288px;
                    min-height: 48px;
                    max-height: 68px;
                    /*box-shadow: 0 2px 5px 0 rgba(0,0,0,0.26);*/
                    box-shadow: 0 2px 5px 0 var(--md-sys-color-shadow);
                    transition: visibility 0s, opacity 0.5s linear;
                }

                .snackbar.show {
                    display: block;
                }

                .content {
                    display: flex;
                }

                .actions {
                    display: flex;
                    align-items: center;
                    margin-right: 8px;
                }

                ::slotted(div[slot="supporting-text"]) {
                    display: flex;
                    flex-grow: 1;
                    padding: 14px 16px;
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

        // Define showSnackbar as a method of the class, not as a property of the instance.
        // This makes it publicly accessible.
        this.showSnackbar = this._showSnackbar.bind(this);
    }

    _showSnackbar = () => {
        this._snackbar.classList.toggle('show');
        setTimeout(() => {
            this._snackbar.classList.remove('show');
        }, this._duration * 1000);
    }

    connectedCallback() {
        if (this._showCloseIcon !== null) {
            this._actions.innerHTML += `<md-icon-button id="closeButton"><md-icon>close</md-icon></md-icon-button>`;
            this._closeButton = this._shadowRoot.getElementById('closeButton');
            // Event listener for the close button
            this._closeButton.addEventListener('click', () => {
                setTimeout(() => {
                    console.debug('Removiendo');
                    this._snackbar.classList.toggle('show');
                    // this._snackbar.classList.toggle('show');
                }, 250); // wait for the transition to complete before hiding it completely
            });
        }
        // this.showSnackbar();
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name === 'behavior') {
            const position = this.getAttribute('behavior');
            if (position === 'fixed') {
                this._snackbar.style.position = 'fixed';
                this._snackbar.style.bottom = '20px';
                this._snackbar.style.left = '50%';
                this._snackbar.style.transform = 'translateX(-50%)';
            } else {
                this._snackbar.style.position = 'absolute';
                this._snackbar.style.bottom = '20px';
                this._snackbar.style.left = '50%';
                this._snackbar.style.transform = 'translateX(-50%)';
            }
        }
    }
}

customElements.define('md-snackbar', Snackbar);
