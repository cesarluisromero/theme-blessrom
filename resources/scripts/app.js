import '../styles/app.css';
import Alpine from 'alpinejs';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Alpine = Alpine;
Alpine.start();
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('menu-toggle');
  const menu = document.getElementById('mobile-menu');

  // ✅ Solo agregar listener si el botón existe
  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      menu.classList.toggle('hidden');
      menu.classList.toggle('animate-slide-in');
    });

    menu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        menu.classList.add('hidden');
      });
    });
  }
});


  document.addEventListener('DOMContentLoaded', function () {
    const updateCartCount = () => {
      fetch('/blessrom/?wc-ajax=get_refreshed_fragments', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      })
      .then(r => r.json())
      .then(data => {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = data.fragments['div.widget_shopping_cart_content'];
        const updatedCart = wrapper.querySelector('#cart-count');
        const target = document.getElementById('cart-count');
  
        if (updatedCart && target) {
          target.textContent = updatedCart.textContent.trim();
          console.log('✅ Actualizado a:', updatedCart.textContent);
        }
      });
    };
  
    // Inicial
    updateCartCount();
  
    // Al agregar producto
    document.body.addEventListener('added_to_cart', updateCartCount);
  
    // Al eliminar producto
    document.body.addEventListener('click', function (e) {
      const removeBtn = e.target.closest('.remove_from_cart_button');
      if (removeBtn) {
        setTimeout(() => {
          updateCartCount();
        }, 1000);
      }
    });
  
    // Fragment refresh
    document.body.addEventListener('wc_fragments_refreshed', updateCartCount);
  });

  document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.swiper', {
      slidesPerView: 4,
      slidesPerGroup: 4,
      loop:true,
      spaceBetween: 10,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      scrollbar: {
        el: '.swiper-scrollbar',
        draggable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 2,
          slidesPerGroup: 2,
        },
        640: {
          slidesPerView: 3,
          slidesPerGroup: 3,
        },
        1024: {
          slidesPerView: 8,
          slidesPerGroup: 8,
        },
      },
    });
  });
  
  
  document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
      once: true,
      duration: 800,
      easing: 'ease-in-out',
    });
  });
  

window.productGallery = function () {
    return {
        init() {
            new Swiper('.product-swiper', {
                pagination: { el: '.swiper-pagination' },
                loop: true,
            });
        }
    }
}

  
  function alpineCart() {
    return {
        selected_pa_talla: '',
        selected_pa_color: '',
        quantity: 1,
        maxQty: 0,
        errorMessage: '',

        validColors() {
            const selectedVariation = this.getSelectedVariation();
            return selectedVariation ? selectedVariation.attributes['attribute_pa_color'] ? [selectedVariation.attributes['attribute_pa_color']] : [] : [];
        },

        selectedVariationId() {
            const variation = this.getSelectedVariation();
            return variation ? variation.variation_id : 0;
        },

        getSelectedVariation() {
            const variations = JSON.parse(this.$root.dataset.product_variations);
            return variations.find(v =>
                v.attributes['attribute_pa_talla'] === this.selected_pa_talla &&
                v.attributes['attribute_pa_color'] === this.selected_pa_color
            );
        },

        updateMaxQty() {
            const variation = this.getSelectedVariation();
            this.maxQty = variation ? parseInt(variation.max_qty || variation.max_qty === 0 ? variation.max_qty : variation.stock_quantity || 0) : 0;
        },

        validateBeforeSubmit(form) {
            if (!this.selected_pa_talla || !this.selected_pa_color) {
                this.errorMessage = 'Debes seleccionar una talla y color.';
            } else {
                this.errorMessage = '';
                form.submit();
            }
        },

        addToCartAjax(form) {
            this.errorMessage = '';
            const formData = new FormData(form);

            fetch(wc_add_to_cart_params.ajax_url, {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.error && response.product_url) {
                    window.location = response.product_url;
                } else {
                    window.location.href = wc_add_to_cart_params.cart_url;
                }
            })
            .catch(error => {
                console.error('Error al agregar al carrito:', error);
                this.errorMessage = 'Ocurrió un error al agregar al carrito.';
            });
        }
    }
}
window.alpineCart = alpineCart; 