// 1. alert( 'yes You did it');

// 2. const products = document.getElementById('products');

// if(products) {
//     products.addEventListener('click', e => {
//         alert('Found it');
//     });
// }

//3. const products = document.getElementById('products');

// if(products) {
//     products.addEventListener('click', e => {
//         if(e.target.className === 'btn btn-danger btn-xs'){
//             alert('Here we go again');

//         }
//     });
// }

// 4. if(confirm('Are You Sure ?')){
//     const id = e.target.getAttribute('data-id');

//     alert(id);
// }

// }
// });
// }

const products = document.getElementById('products');

if(products) {
    products.addEventListener('click', e => {
        if(e.target.className === 'btn btn-danger btn-xs'){
            if(confirm('Are You Sure ?')){
                const id = e.target.getAttribute('data-id');

                fetch(`product/delete/${id}`, {
                    method: 'DELETE'
                }).then(_res => window.location.reload());
            }

        }
    });
}