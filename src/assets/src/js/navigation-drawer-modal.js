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

class NavigationDrawerModal extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    this.shadowRoot.innerHTML = `
      <style>
        :host {
            --md-list-container-color: transparent;
        }

        .drawer {
          position: fixed;
          top: 0;
          left: 0;
          height: 100%;
          width: 300px;
          background-color: var(--md-sys-color-surface);
          color: var(--md-sys-color-on-surface);
          transform: translateX(-100%);
          transition: transform 0.3s ease-in-out;
          box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
          z-index: 1000;
          border-top-right-radius: 16px;
          border-bottom-right-radius: 16px;
        }

        .drawer.open {
          transform: translateX(0);
        }

        .drawer nav {
          margin-inline: 12px;
        }

        .drawer md-list {
          padding-top: 8px;
        }

        .scrim {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.5);
          opacity: 0;
          visibility: hidden;
          transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
          z-index: 999;
        }

        .scrim.open {
          opacity: 1;
          visibility: visible;
        }
      </style>
      <aside class="drawer">
          <nav>
              <slot></slot>
          </nav>
      </aside>
      <div class="scrim"></div>
    `;
    this.drawer = this.shadowRoot.querySelector('.drawer');
    this.scrim = this.shadowRoot.querySelector('.scrim');
    document.querySelector('md-navigation-drawer-modal').querySelectorAll('md-list-item[href]').forEach((item) => {
      item.style.borderRadius = '28px';
    });

  }

  toggle() {
    this.drawer.classList.toggle('open');
    this.scrim.classList.toggle('open');
  }

  connectedCallback() {
    this.scrim.addEventListener('click', () => this.toggle());
    this.shadowRoot.querySelector('slot').addEventListener('click', (event) => {
      if (event.target.tagName === 'A') {
        this.toggle();
      }
    });
  }
}

customElements.define('md-navigation-drawer-modal', NavigationDrawerModal);
