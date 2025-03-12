/**
 * @preserve
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
 * @endpreserve
 */

class MdOutlinedCard extends HTMLElement {
    constructor() {
        super();

        // Crear el Shadow DOM
        this.attachShadow({ mode: 'open' });

        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    box-sizing: border-box;
                    display: flex;
                    flex-direction: column;
                    position: relative;
                    z-index: 0;
                    border-radius: var(--md-outlined-card-container-shape, var(--md-sys-shape-corner-medium, 12px));
                    border: var(--md-outlined-card-outline-width, 1px) solid var(--md-outlined-card-outline-color);
                    --md-elevation-level: var(--md-outlined-card-container-elevation);
                }

                md-elevation {
                    transition-duration: 280ms;
                    transition-timing-function: cubic-bezier(0.2, 0, 0, 1);
                }

                md-elevation,
                .background,
                .outline {
                    border-radius: inherit;
                    inset: 0;
                    pointer-events: none;
                    position: absolute;
                }

                .background {
                    background: var(--md-outlined-card-container-color);
                    z-index: -1;
                }

                .outline {
                    border: 1px solid transparent;
                    z-index: 1;
                }

                slot {
                    border-radius: inherit;
                }

                ::slotted(div[slot="actions"]) {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    box-sizing: border-box;
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

class MdFilledCard extends HTMLElement {
    constructor() {
        super();

        // Crear el Shadow DOM
        this.attachShadow({ mode: 'open' });

        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    box-sizing: border-box;
                    display: flex;
                    flex-direction: column;
                    position: relative;
                    z-index: 0;
                    border-radius: var(--md-filled-card-container-shape, var(--md-sys-shape-corner-medium, 12px));
                    --md-elevation-level: var(--md-filled-card-container-elevation);
                }

                md-elevation {
                    transition-duration: 280ms;
                    transition-timing-function: cubic-bezier(0.2, 0, 0, 1);
                }

                md-elevation,
                .background,
                .outline {
                    border-radius: inherit;
                    inset: 0;
                    pointer-events: none;
                    position: absolute;
                }

                .background {
                    background: var(--md-filled-card-container-color);
                    z-index: -1;
                }

                .outline {
                    border: 1px solid transparent;
                    z-index: 1;
                }

                slot {
                    border-radius: inherit;
                }

                ::slotted(div[slot="actions"]) {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    box-sizing: border-box;
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
                    box-sizing: border-box;
                    display: flex;
                    flex-direction: column;
                    position: relative;
                    z-index: 0;
                    border-radius: var(--md-elevated-card-container-shape, var(--md-sys-shape-corner-medium, 12px));
                    box-shadow: 0px 1px 3px 0px var(--md-elevated-card-container-shadow-color);
                    --md-elevation-level: var(--md-elevated-card-container-elevation);
                }

                md-elevation {
                    transition-duration: 280ms;
                    transition-timing-function: cubic-bezier(0.2, 0, 0, 1);
                }

                md-elevation,
                .background,
                .outline {
                    border-radius: inherit;
                    inset: 0;
                    pointer-events: none;
                    position: absolute;
                }

                .background {
                    background: var(--md-elevated-card-container-color);
                    z-index: -1;
                }

                .outline {
                    border: 1px solid transparent;
                    z-index: 1;
                }

                slot {
                    border-radius: inherit;
                }

                ::slotted(div[slot="actions"]) {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    box-sizing: border-box;
                    padding: 16px;
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

customElements.define('md-outlined-card', MdOutlinedCard);
customElements.define('md-filled-card', MdFilledCard);
customElements.define('md-elevated-card', MdElevatedCard);