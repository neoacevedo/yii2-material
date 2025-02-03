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

class NavigationDrawerStandard extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.innerHTML = `
      <style>
        /* Estilos para el modo estándar */
        .drawer {
          width: 300px;
          background-color: var(--md-sys-color-surface);
          color: var(--md-sys-color-on-surface);
          box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
          height: 100%;
          overflow-y: auto;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li a {
            display: block;
            padding: 12px 16px;
            text-decoration: none;
            color: inherit;
            transition: background-color 0.2s;
            border-radius: 28px;
        }

        li a:hover {
            background-color: var(--md-sys-color-surface-variant);
        }

        md-list md-list-item[href] {
            border-radius: 28px;
        }

        .main-content {
            margin-left: 300px;
            transition: margin-left 0.3s ease-in-out;
        }
        .main-content.drawer-closed {
            margin-left: 0;
        }
      </style>
      <aside class="drawer">
        <slot></slot>
      </aside>
    `;
        this.mainContent = document.querySelector('main');
    }

    toggle() {
        this.mainContent.classList.toggle('drawer-closed');
    }

    connectedCallback() {
        this.shadowRoot.querySelector('slot').addEventListener('click', (event) => {
            if (event.target.tagName === 'A') {
                this.toggle();
            }
        });
    }
}

customElements.define('md-navigation-drawer', NavigationDrawerStandard);
