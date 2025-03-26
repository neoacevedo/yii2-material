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

class TopAppBar extends HTMLElement {

    constructor() {
        super();

        // Crear el Shadow DOM para encapsulamiento
        this.attachShadow({ mode: 'open' });

        // Plantilla HTML (puedes usar template literals o un elemento <template>)
        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    display: block;
                    width: 100%;
                    background-color: var(--md-sys-color-surface);
                    color: var(--md-sys-color-on-surface);
                    /* box-shadow: 0px 2px 4px -1px rgba(0,0,0,0.2), 0px 4px 5px 0px rgba(0,0,0,0.14), 0px 1px 10px 0px rgba(0,0,0,0.12); */ /* Material 3 elevation */
                    /* Consider using tokens for elevation in a real application */
                }

                .top-app-bar {
                    display: flex;
                    align-items: center;
                    padding: 0 16px; /* Standard left and right padding */
                    height: 64px; /* Standard height for Top App Bar */
                }

                .leading {
                    display: flex;
                    align-items: center;
                    margin-right: 16px; /* Spacing between leading and title */
                }

                .title {
                    flex-grow: 1;
                    font-family: 'Roboto', sans-serif; /* Material 3 font */
                    font-size: 1.25rem; /* Material 3 headline small */
                    font-weight: 500; /* Material 3 headline small font weight */
                    line-height: 2rem; /* Material 3 headline small line height */
                    letter-spacing: 0.0125em; /* Material 3 headline small letter spacing */
                }

                .trailing {
                    display: flex;
                    align-items: center;
                    margin-left: 16px; /* Spacing between title and trailing */
                }

                ::slotted(*) {
                    /* Basic styling for slotted elements */
                    display: inline-flex;
                    align-items: center;
                }

                ::slotted(button),
                ::slotted(a) {
                    /* Style for slotted buttons and links (icons) */
                    border: none;
                    background: none;
                    padding: 8px;
                    margin: 0 4px;
                    cursor: pointer;
                    color: var(--md-sys-color-on-surface-variant)); /* Example icon color */
                    border-radius: 50%; /* Circular shape for icons */
                }

                ::slotted(button:hover),
                ::slotted(a:hover) {
                    background-color: rgba(0, 0, 0, 0.08); /* Ripple effect on hover */
                }

                ::slotted([slot="leading-icon"]) {
                    margin-right: 16px;
                }

                ::slotted([slot="trailing-icon"]) {
                    margin-left: 16px;
                }
            </style>
            <div class="top-app-bar">
                <div class="leading">
                    <slot name="leading-icon"></slot>
                </div>
                <div class="title">
                    <slot name="headline"></slot>
                </div>
                <div class="trailing">
                    <slot name="trailing-icon"></slot>
                </div>
            </div>
        `;
    }

    // connectedCallback() {
    //     // Acciones cuando el componente se conecta al DOM
    //     const menuButton = this.shadowRoot.querySelector('.menu-button');
    //     menuButton.addEventListener('click', this.toggleMenu.bind(this));
    // }

    // disconnectedCallback() {
    //     // Acciones cuando el componente se desconecta del DOM (limpiar listeners)
    //     const menuButton = this.shadowRoot.querySelector('.menu-button');
    //     menuButton.removeEventListener('click', this.toggleMenu.bind(this));
    // }

    // toggleMenu() {
    //     // Implementar la lógica para mostrar/ocultar el menú (ej. dispatchEvent)
    //     const menuEvent = new CustomEvent('menu-toggle', {
    //         bubbles: true, // Permite que el evento se propague hacia arriba en el DOM
    //         composed: true // Permite que el evento atraviese el shadow DOM
    //     })
    //     this.dispatchEvent(menuEvent);
    // }
}

// Registrar el componente
window.customElements.define('md-top-app-bar', TopAppBar);