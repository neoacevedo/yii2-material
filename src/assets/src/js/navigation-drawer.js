/**
 * @preserve
 * 
 * @copyright Copyright (c) 2025 neoacevedo
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

class NavigationDrawer extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    this._isOpen = false;
    this._type = this.getAttribute('type') || 'modal'; // Default to modal
  }

  static get styles() {
    return /*css*/`
      :host {
        display: flex;
        flex-direction: column;
        top: 0;
        left: 0;
        height: 100vh;
        background-color: var(--md-sys-color-surface);
        box-shadow: var(--md-sys-elevation-level-3, 0px 1px 3px 0px rgba(0, 0, 0, 0.12), 0px 2px 6px 2px rgba(0, 0, 0, 0.06));
        z-index: 10;
        transition: transform 0.3s ease-in-out;
      }

      /* Estilos comunes a ambos modos */
      .drawer {
        width: 320px;
      }

      .drawer-header {
        padding: 16px;
      }

      .drawer-title {
        font-family: 'Roboto', sans-serif;
        font-size: 1.25rem;
        font-weight: 500;
        color: var(--md-sys-color-on-surface);
        margin: 0;
      }

      .drawer-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
      }

      .drawer-list-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        cursor: pointer;
        text-decoration: none;
        color: var(--md-sys-color-on-surface);
        border-radius: var(--md-sys-shape-corner-full);
      }

      .drawer-list-item:hover {
          background-color: rgba(var(--md-sys-color-primary-rgb, 103, 80, 164), 0.08);
          border-radius: var(--md-sys-shape-corner-full);
      }

      .drawer-list-item.active {
        background-color: rgba(var(--md-sys-color-primary-rgb, 103, 80, 164), 0.16);
        color: var(--md-sys-color-primary);
        border-radius: var(--md-sys-shape-corner-full);
      }

      .drawer-list-item .item-icon {
        margin-right: 16px;
      }

      .drawer-list-item .item-text {
        font-family: 'Roboto', sans-serif;
        font-size: 1rem;
        font-weight: 400;
      }

      /* Estilos específicos para el modo modal */
      :host([mode="modal"]) {
        width: 300px; /* Ancho típico para modal */
        transform: translateX(-100%);
      }

      :host([mode="modal"].open) {
        transform: translateX(0);
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
        transition: opacity 0.3s ease-in-out, visibility 0s 0.3s;
        z-index: 9; /* Debajo del drawer modal */
      }

      :host([mode="modal"].open) + .scrim {
        opacity: 1;
        visibility: visible;
        transition: opacity 0.3s ease-in-out, visibility 0s 0s;
      }

      /* Estilos específicos para el modo estándar */
      :host([mode="standard"]) {
        width: 240px; /* Ancho típico para estándar */
        transform: translateX(0); /* Siempre visible */
        border-right: 1px solid var(--md-sys-color-outline);
      }

      :host([mode="standard"]) .drawer-header {
        border-bottom: none; /* Opcional: quitar el borde inferior en modo estándar */
      }
    `;
  }

  connectedCallback() {
    this._type = this.getAttribute('type') || 'modal';
    this.shadowRoot.innerHTML = `
      <style>${NavigationDrawer.styles}</style>
      <div class="drawer">
        <div class="drawer-header">
          <h2 class="drawer-title"><slot name="title">Menú</slot></h2>
        </div>
        <ul class="drawer-list">
          <slot name="content"></slot>
        </ul>
      </div>
      ${this._type === 'modal' ? '<div class="scrim"></div>' : ''}
    `;
    this._drawerElement = this.shadowRoot.querySelector('.drawer');
    if (this._type === 'modal') {
      this._scrimElement = this.shadowRoot.querySelector('.scrim');
      this._scrimElement.addEventListener('click', this._closeDrawer.bind(this));
    }
  }

  disconnectedCallback() {
    if (this._type === 'modal' && this._scrimElement) {
      this._scrimElement.removeEventListener('click', this._closeDrawer.bind(this));
    }
  }

  static get observedAttributes() {
    return ['mode'];
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (name === 'mode' && oldValue !== newValue) {
      this._type = newValue;
      // Re-render the component to apply the new mode's structure and styles
      this.connectedCallback();
    }
  }

  open() {
    if (this._type === 'modal') {
      this._isOpen = true;
      this.classList.add('open');
      const scrim = this.shadowRoot.querySelector('.scrim');
      if (scrim) {
        scrim.classList.add('open');
      }
      document.body.style.overflow = 'hidden';
    } else if (this._type === 'standard') {
      // En modo estándar, el drawer generalmente está siempre abierto
      console.warn("El método 'open()' no tiene efecto en el modo 'standard'.");
    }
  }

  close() {
    if (this._type === 'modal') {
      this._isOpen = false;
      this.classList.remove('open');
      const scrim = this.shadowRoot.querySelector('.scrim');
      if (scrim) {
        scrim.classList.remove('open');
      }
      document.body.style.overflow = '';
    } else if (this._type === 'standard') {
      // En modo estándar, el drawer generalmente está siempre abierto
      console.warn("El método 'close()' no tiene efecto en el modo 'standard'.");
    }
  }

  _closeDrawer() {
    this.close();
  }

  toggle() {
    if (this._type === 'modal') {
      this._isOpen ? this.close() : this.open();
    } else if (this._type === 'standard') {
      console.warn("El método 'toggle()' no tiene efecto en el modo 'standard'.");
    }
  }
}

customElements.define('md-navigation-drawer', NavigationDrawer);
