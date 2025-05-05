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

let sharedStyles = `
:host{border-radius:var(--_container-shape);box-sizing:border-box;display:flex;flex-direction:column;position:relative;z-index:0;}

md-elevation,.background,.outline{border-radius:inherit;inset:0;pointer-events:none;position:absolute}.background{background:var(--_container-color);z-index:-1}.outline{border:1px solid rgba(0,0,0,0);z-index:1}md-elevation{z-index:-1;--md-elevation-level: var(--_container-elevation);--md-elevation-shadow-color: var(--_container-shadow-color)}slot{border-radius:inherit}
`;

let elevatedStyles = ':host{--_container-color: var(--md-elevated-card-container-color, var(--md-sys-color-surface-container-low, #f7f2fa));--_container-elevation: var(--md-elevated-card-container-elevation, 1);--_container-shadow-color: var(--md-elevated-card-container-shadow-color, var(--md-sys-color-shadow, #000));--_container-shape: var(--md-elevated-card-container-shape, var(--md-sys-shape-corner-medium, 12px))}';

let filledStyles = ':host{--_container-color: var(--md-filled-card-container-color, var(--md-sys-color-surface-container-highest, #e6e0e9));--_container-elevation: var(--md-filled-card-container-elevation, 0);--_container-shadow-color: var(--md-filled-card-container-shadow-color, var(--md-sys-color-shadow, #000));--_container-shape: var(--md-filled-card-container-shape, var(--md-sys-shape-corner-medium, 12px))}';

let outlinedStyles = ':host{--_container-color: var(--md-outlined-card-container-color, var(--md-sys-color-surface, #fef7ff));--_container-elevation: var(--md-outlined-card-container-elevation, 0);--_container-shadow-color: var(--md-outlined-card-container-shadow-color, var(--md-sys-color-shadow, #000));--_container-shape: var(--md-outlined-card-container-shape, var(--md-sys-shape-corner-medium, 12px));--_outline-color: var(--md-outlined-card-outline-color, var(--md-sys-color-outline-variant, #cac4d0));--_outline-width: var(--md-outlined-card-outline-width, 1px)}.outline{border-color:var(--_outline-color);border-width:var(--_outline-width)}';

class MdOutlinedCard extends HTMLElement {
    constructor() {
        super();

        // Crear el Shadow DOM
        this.attachShadow({ mode: 'open' });

        this.shadowRoot.innerHTML = `
            <style>
                ${sharedStyles}
                ${outlinedStyles}

                ::slotted(div[slot="actions"]) {
                    display: flex;
                    flex-direction: row;
                    align-items: end;
                    justify-content: end;
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
                ${sharedStyles}
                ${filledStyles}

                ::slotted(div[slot="actions"]) {
                    display: flex;
                    flex-direction: row;
                    align-items: end;
                    justify-content: end;
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
                ${sharedStyles}
                ${elevatedStyles}

                ::slotted(div[slot="actions"]) {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    justify-content: center;
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