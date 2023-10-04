document.addEventListener("DOMContentLoaded", () => {
    const addToCardBtns = document.querySelectorAll(".add-to-cart");
    const checkoutBtn = document.querySelector('#checkout');
    const buyBtn = document.querySelector('#buy');
    const logoutBtn = document.querySelector('#logout');

    logoutBtn.addEventListener('click', () => {
        localStorage.removeItem('products'); 
    });

    buyBtn.addEventListener('click', () => buy());

    const storedProducts = JSON.parse(localStorage.getItem("products")) || [];
    const parsedProducts = [];

    storedProducts.forEach((product, i) => {
        parsedProducts[i] = JSON.parse(product);
    });

    checkoutBtn.addEventListener('click', () => {
        const storedProducts = JSON.parse(localStorage.getItem("products")) || [];
        const parsedProducts = [];
    
        storedProducts.forEach((product, i) => {
            parsedProducts[i] = JSON.parse(product);
        });

      checkout(parsedProducts);
    });

    addToCardBtns.forEach((btn) =>
        btn.addEventListener("click", () => {
            const product = btn.dataset.product;
            addToCart(product);
        })
    );

    getCart();
});

function addToCart(product) {
    const storedProducts = JSON.parse(localStorage.getItem("products")) || [];

    storedProducts[storedProducts.length] = product;

    localStorage.products = JSON.stringify(storedProducts);

    getCart();
}

function getCart() {
    const cartListElem = document.querySelector("#cart-list");
    cartListElem.innerHTML = ``;
    
    const storedProducts = JSON.parse(localStorage.getItem("products")) || [];
    const parsedProducts = [];
    storedProducts.forEach((product, i) => {
        parsedProducts[i] = JSON.parse(product);
    });

    parsedProducts.forEach((p, i) => {
        const elem = document.createElement("div");
        elem.classList.add("col-md-4", "product-card");

        elem.innerHTML = `
            <div class="card">
                <img src="${p.picture_url}" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title">${p.name}</h5>
                    <p class="card-text">${p.description}</p>
                    <p class="card-text">${p.price } ₸</p>
                </div>
            </div>
    `;
        cartListElem.append(elem);
    });
}

function checkout(products) {
  let checkoutResult = 0
  console.log(products);

  products.forEach((product) => {
    checkoutResult += parseFloat(product.price)
  });

  alert(`Price: ${checkoutResult} ₸`);
}

function buy() {
    const storedProducts = JSON.parse(localStorage.getItem("products")) || [];
    const parsedProducts = [];

    storedProducts.forEach((product, i) => {
        parsedProducts[i] = JSON.parse(product);
    });


    fetch('/orders', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({products: parsedProducts}),
    }).then(data => data.json()).then(data => alert(JSON.stringify((data.message)))).catch(err => alert(err.message)).finally(() => {    
        location.reload()
    })
}