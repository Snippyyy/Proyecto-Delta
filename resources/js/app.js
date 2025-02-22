import './bootstrap';
import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import tinymce from 'tinymce';

document.addEventListener("DOMContentLoaded", function() {
    if (document.querySelector("#editor")) {
        tinymce.init({
            selector: '#editor',
            menubar: false,
            plugins: 'lists link preview',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent',
            height: 300
        });
    }
});


window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.getElementById('menu-button');
    const menu = menuButton.nextElementSibling;

    menuButton.addEventListener('click', function () {
        const expanded = menuButton.getAttribute('aria-expanded') === 'true' || false;
        menuButton.setAttribute('aria-expanded', !expanded);
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', function (event) {
        if (!menuButton.contains(event.target) && !menu.contains(event.target)) {
            menuButton.setAttribute('aria-expanded', 'false');
            menu.classList.add('hidden');
        }
    });

    const swiper = new Swiper('.swiper', {

        modules: [Navigation, Pagination],
        direction: 'horizontal',
        loop: true,

        pagination: {
            el: '.swiper-pagination',
        },

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });
});
