document.addEventListener('DOMContentLoaded', () => {
  const statusBtns = document.querySelectorAll(".btn-status")

  statusBtns.forEach((btn) => {
    const orderId = btn.dataset.orderId;
    const btnValue = btn.dataset.value;

    btn.addEventListener('click', () => {
      fetch(`/orders/change-order-status/${orderId}`, {
        method: 'PUT',
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
          status: btnValue
        })
      }).then(data => {
        location.reload();
        alert('Status succefully updated');
      })
    })
  })
});