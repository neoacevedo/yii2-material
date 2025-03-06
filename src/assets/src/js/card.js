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

class MdOutlinedCard extends HTMLElement {
    constructor() {
        super();

        // Crear el Shadow DOM
        this.attachShadow({ mode: 'open' });

        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    display: flex;
                    flex-direction: column;
                }
            </style>
            <md-elevation part="elevation"></md-elevation>
            <div class="background"></div>
            <slot></slot>
            <div class="outline"></div>
        `;
    }
}

class MdFilledCard extends HTMLElement {
    constructor() {
        super();

        // Crear el Shadow DOM
        this.attachShadow({ mode: 'open' });

        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    display: flex;
                    flex-direction: column;
                    background-color: var(--md-filled-card-container-color, var(--md-sys-color-surface-container-low, #f7f2fa));
                    border-radius: var(--md-filled-card-container-shape, var(--md-sys-shape-corner-medium, 12px));
                }
            </style>
            <md-elevation part="elevation"></md-elevation>
            <div class="background"></div>
            <slot></slot>
            <slot name="actions"></slot>
            <div class="outline"></div>
        `;
    }
}

class MdElevatedCard extends HTMLElement {
    constructor() {
        super();

        // Crear el Shadow DOM
        this.attachShadow({ mode: 'open' });

        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    display: flex;
                    flex-direction: column;
                    background-color: var(--md-elevated-card-container-color, var(--md-sys-color-surface-container-low, #f7f2fa));
                    border-radius: var(--md-elevated-card-container-shape, var(--md-sys-shape-corner-medium, 12px));
                    box-shadow: 0 2px 4px var(--md-elevated-card-container-shadow-color, var(--md-sys-color-shadow, #000050));
                    --md-elevation-level: var(--md-elevated-card-container-elevation);
                }

                md-elevation {
                    transition-duration: 280ms;
                    transition-timing-function: cubic-bezier(0.2, 0, 0, 1);
                }
            </style>
            <md-elevation part="elevation"></md-elevation>
            <div class="background"></div>
            <slot></slot>
            <div class="outline"></div>
        `;
    }
}

customElements.define('md-outlined-card', MdOutlinedCard);
customElements.define('md-filled-card', MdFilledCard);
customElements.define('md-elevated-card', MdElevatedCard);