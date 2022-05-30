/*!
Theme Name: Kallisto
Author: Roman Dudnyk
Author URI: http://dudnyk.rb@gmail.com
Version: 1.0.0
*/

'use strict'

import {clearInputFile} from "./modules/clearInputFile.js";
import {clearForm} from "./modules/clearForm.js";
import {showNameImage} from "./modules/showNameImage.js";

document.addEventListener('DOMContentLoaded', () => {

    document.querySelector('#masthead .menu-btn').addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('#masthead .menu-btn').classList.toggle('checked');
        document.querySelector('#fixed-menu').classList.toggle('active');
        document.querySelector('body').classList.toggle('stop');
    });

    //Clearing form file in add product
    let formContainer = document.querySelector('#add-product');

    if(formContainer) {

        let realForm = formContainer.querySelector('form.add-product-form'),
            formClear = formContainer.querySelector('#productReset'),
            formFile = formContainer.querySelector('#productImage'),
            formFileTitle = formContainer.querySelector('.form-file-label'),
            formFileTitleText = formFileTitle.textContent,
            formFileClear = formContainer.querySelector('#productImageRemove');

        formFileClear.addEventListener('click', () => {
            clearInputFile(formFile);
            formFileTitle.textContent = formFileTitleText;
        });

        formFile.onchange = function () {
            showNameImage(formFile, formFileTitle);
        }

        formClear.addEventListener('click', () => {
            clearForm(realForm);
        });
    }
});