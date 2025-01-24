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
      <style id="componentStyles"></style>
      <header class="top-app-bar">
        <div class="top-app-bar-container">
            <slot name="leading-icon"></slot>
            <span class="app-title md-sys-typescale-headline-large-size">
                <slot name="title">Título por defecto</slot>
            </span>
            <slot name="trailing-icon"></slot>
        </div>
      </header>
    `;
    }

    connectedCallback() {
        this.injectStyles(); // Inyectar estilos al conectar el componente
    }

    injectStyles() {
        const styleTag = this.shadowRoot.getElementById('componentStyles');
        if (window.topAppBarStyles) { // Verifica si window.topAppBarStyles existe
            styleTag.textContent = window.topAppBarStyles;
        } else {
            console.error('No se encontraron los estilos para el componente TopAppBar. Asegurate de que el AssetBundle se este registrando correctamente');
        }
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