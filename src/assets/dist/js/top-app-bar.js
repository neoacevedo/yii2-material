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

class TopAppBar extends HTMLElement {
    constructor() {
        super();

        // Crear el Shadow DOM para encapsulamiento
        this.attachShadow({ mode: 'open' });

        // Plantilla HTML (puedes usar template literals o un elemento <template>)
        this.shadowRoot.innerHTML = `
      <style>
        /* Estilos CSS (usando variables de Material, como se explicó antes) */
            .top-app-bar {
                background-color: var(--md-sys-color-surface);
                color: var(--md-sys-color-on-surface);
                box-shadow: 0 2px 4px rgba(var(--md-sys-color-shadow), 0.1);
                position: sticky;
                top: 0;
                width: 100%;
                z-index: 100;
            }

            .top-app-bar-container {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px;
                max-width: 100%;
            }

            .app-title {
                font-family: var(--md-sys-typescale-headline-small-font-family-name);
                font-weight: var(--md-sys-typescale-headline-small-font-weight);
                font-size: var(--md-sys-typescale-headline-large-size) !important;
                line-height: var(--md-sys-typescale-headline-small-line-height);
                letter-spacing: var(--md-sys-typescale-headline-small-letter-spacing);
                flex-grow: 1; /* Para que el título ocupe el espacio disponible */
                text-align: start; /* Centrar el título */
                padding-inline: 12px;
            }

            .top-app-bar.center-aligned .app-title {
                justify-content: center;
            }

            /* Estilos adicionales para la variante "medium" con Search Bar */
            .top-app-bar.medium {
                display: grid; /* Usamos grid para el diseño */
                grid-template-rows: auto auto; /* Dos filas: barra superior y barra de búsqueda */
                gap: 8px; /* Espacio entre filas */
                padding-bottom: 8px; /* Reducir el padding inferior de la barra superior */
            }

            .top-app-bar.large { /* Clase para la variante "large" */
                padding-top: 24px; /* Aumentar el padding vertical */
                padding-bottom: 24px;
                background-size: cover;
                background-position: center;
            }

            .top-app-bar.medium .top-app-bar-container{
                padding-bottom: 0px;
            }

            .search-bar { /* Estilos para la barra de búsqueda */
                padding: 8px 16px;
                background-color: var(--md-sys-color-surface-variant);
                border-radius: 4px;
                display: flex;
                align-items: center;
            }

            .search-bar input {
                border: none;
                background: none;
                flex-grow: 1;
            }

            .top-app-bar.large .app-title {
                font-size: var(--md-sys-typescale-display-small-font-size); /* Título más grande */
                font-weight: var(--md-sys-typescale-display-small-font-weight);
            }

            .leading-icon-button,
            .action-button {
                border: none;
                background: none;
                padding: 8px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .actions {
                display: flex;
            }
      </style>
      <header class="top-app-bar">
        <div class="top-app-bar-container">
            <slot name="leading-icon"></slot>
            <span class="app-title"><slot name="title">Título por defecto</slot></span>
            <slot name="trailing-icon"></slot>
        </div>
      </header>
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