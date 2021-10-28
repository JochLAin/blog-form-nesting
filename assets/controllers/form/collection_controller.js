import { Controller } from '@stimulus/core';

export default class FormCollectionController extends Controller {
    static targets = ['container', 'btnAdd'];

    connect() {
        if (this.element.dataset.prototype) {
            this.btnAddTarget.addEventListener('click', this.onClickAdd);
        }
        this.element.addEventListener('click', this.onClickDelete);
    }

    disconnect() {
        if (this.element.dataset.prototype) {
            this.btnAddTarget.removeEventListener('click', this.onClickAdd);
        }
        this.element.removeEventListener('click', this.onClickDelete);
    }

    onClickAdd = (evt) => {
        evt.preventDefault();
        const { name = '', prototype } = this.element.dataset;
        if (prototype) {
            const idx = Math.random().toString(36).substr(2, 9);
            const tmp = document.createElement('div');
            tmp.innerHTML = prototype
                .replace(new RegExp(`${name}___name__`, 'g'), `${name}_${idx}`)
                .replace(new RegExp(`${name}[__name__]`, 'g'), `${name}[${idx}]`)
            ;

            this.containerTarget.append(tmp.firstElementChild);
        }
    };

    onClickDelete = (evt) => {
        if (evt.target.matches('.form--collection-deletor')) {
            evt.preventDefault();
            evt.target.closest('.form-collection--item').remove();
        }
    };
}
