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
            width: 80px;
            height: 100%;
        }

        ::slotted(div) {
          display: flex;
          flex-direction: column;
          width: 80px;
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
        <slot name="leading"></slot>
        <slot name="content"></slot>
        <slot name="trailing"></slot>
      </nav>
    `;
  }

  connectedCallback() {
    const navLeading = this.shadowRoot.querySelector('slot[name=leading]');

    if (navLeading) {
      navLeading.addEventListener('slotchange', () => {
        const leading = navLeading.assignedNodes();
        if (leading.length > 0) {
          leading[0].style = `
              margin-top: 12px;
              padding-left: 12px;
              padding-right: 12px;
          `;
        }
      });
    }

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

                navItem.innerHTML += `
                  <style>
                    .nav-item {
                      color: var(--md-sys-color-primary);
                      width: 80px;
                      height: 56px;
                      padding-left: 12px;
                      padding-right: 12px;
                      text-decoration: none;
                      justify-content: center;
                      text-align: center;
                      margin-bottom: 12px;
                      overflow: hidden;
                      text-overflow: ellipsis;
                    }
                  </style>
                `;

                if (icon) {
                  icon.innerHTML += `
                    <style>
                      .icon {
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
                      }
                    </style>
                  `;

                  if (navItem.classList.contains('active')) {
                    navItem.innerHTML += `
                        <style>
                          .active .icon {
                            position: relative;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            background-color: var(--md-sys-color-surface-container);
                            color: var(--md-sys-color-on-secondary-container);
                            opacity: 1;
                            transform: scaleX(1);
                            margin-right: auto;
                            margin-left: auto;
                            border-radius: 16px;
                          }
                        </style>
                      `;
                  }

                  navItem.addEventListener('mouseenter', () => {
                    navItem.style.fontVariationSettings = '"FILL" 1, "wght" 600,"opsz" 24';
                  });

                  navItem.addEventListener('mouseleave', () => {
                    // if (navItem.classList.contains('active')) {
                    //   icon.style.backgroundColor = 'var(--md-sys-color-surface-container)';
                    // } else {
                    //   icon.style.backgroundColor = '';
                    // }
                    navItem.style.fontVariationSettings = '';
                  });
                }

                if (label) {
                  label.classList.add('md-typescale-label-medium');
                  label.style = `
                    margin-top: 4px;
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
