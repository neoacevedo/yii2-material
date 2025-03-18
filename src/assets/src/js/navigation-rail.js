/**
 * @preserve
 * 
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
 * 
 * @endpreserve
 */
// @endpreserve
class NavigationRail extends HTMLElement {
  constructor() {
    super();

    // Crear Shadow DOM para encapsular estilos y evitar conflictos
    this.attachShadow({ mode: 'open' });

    // Estilos CSS (usando tokens de Material 3)
    this.shadowRoot.innerHTML = `
      <style>
        :host {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            background: var(--md-sys-color-surface);
            overflow-y: auto;
            z-index: 8;
        }

        .navigation-rail {
            display: flex;
            flex-direction: column;
            width: 88px;
            height: 100%;
        }

        ::slotted(div) {
          display: flex;
          flex-direction: column;
          width: 88px;
        }
      </style>
    `;

    if (this.classList.contains('align-bottom')) {
      this.shadowRoot.innerHTML += `
        <style>
            ::slotted(.navigation-rail-content) {
              margin-top: auto;
              margin-bottom: 36px;
            }
        </style>
      `;
    }

    if (this.classList.contains('align-center')) {
      this.shadowRoot.innerHTML += `
        <style>
            ::slotted(.navigation-rail-content) {
              margin-top: auto;
              margin-bottom: auto;
            }
        </style>
      `;
    }

    this.shadowRoot.innerHTML += `
      <nav class="navigation-rail">
        <div class="menu-toggler">
          <slot name="menu"></slot>
        </div>
        <slot name="content"></slot>
      </nav>
    `;
  }

  connectedCallback() {
    const navItemsSlot = this.shadowRoot.querySelector('slot[name=content]');

    if (navItemsSlot) { // Verifica que el slot exista
      navItemsSlot.addEventListener('slotchange', () => {
        const navItems = navItemsSlot.assignedNodes();
        navItems.forEach(item => {
          if
            (
            item.nodeType === 8
            ||
            (item.nodeType === 3 && !/\S/.test(item.nodeValue))
          ) {
            return;
          }

          if (item.classList.contains('navigation-rail-content')) {
            const navItems = item.querySelectorAll('.nav-item');

            navItems.forEach(navItem => {
              if (navItem) {
                const icon = navItem.querySelector('.icon');
                const label = navItem.querySelector('.label');

                navItem.style = `
                  width: 80px;
                  height: 56px;
                  padding: 2px;
                  margin-top: 2px;
                  color: var(--md-sys-color-primary);
                  text-decoration: none;
                  justify-content: center;
                  text-align: center;
                `;

                if (icon) {
                  icon.style = `
                    position: relative;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 56px;
                    height: 24px;
                    margin-right: auto;
                    margin-left: auto;
                    border-radius: 16px;
                    transition-duration: .2s;
                    transition-property: transform,opacity;
                  `;


                  if (navItem.classList.contains('active')) {
                    icon.style.backgroundColor = 'var(--md-sys-color-surface-container)';
                    icon.style.opacity = 1;
                    icon.style.transform = 'scaleX(1)';
                  }

                  navItem.addEventListener('mouseenter', () => {
                    icon.style.fontVariationSettings = '"FILL" 1, "wght" 600,"opsz" 24';
                  });

                  navItem.addEventListener('mouseleave', () => {
                    if (navItem.classList.contains('active')) {
                      icon.style.backgroundColor = 'var(--md-sys-color-surface-container)';
                    } else {
                      icon.style.backgroundColor = '';
                    }
                    icon.style.fontVariationSettings = '"wght" 400,"opsz" 24';
                  });
                }

                if (label) {
                  label.style = `
                            font-size: 12px;
                            margin-bottom: 4px;
                            text-align: center;
                            pointer-events: none;
                          `;
                }
              }
            });
          }
        });
      });
    } else {
      console.error('No se encontró el slot "nav-item" en el Shadow DOM.');
    }
  }

}

customElements.define('md-navigation-rail', NavigationRail);
