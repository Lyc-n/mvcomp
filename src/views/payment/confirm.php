<div id="payment" class="flex flex-col w-full h-dvh items-center mx-auto gap-4">
    <h2 class="text-3xl font-bold text-left ">Konfirmasi Pembayaran</h2>
    <p>Total: Rp <?= number_format($cart['total'], 0, ',', '.') ?></p>
    <button id="pay-button" class="bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Bayar Sekarang</button>
</div>

<script>
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
        snap.pay('<?= $snapToken ?>', {
            onSuccess: function(result) {
                console.log('Pembayaran berhasil:', result);
                alert('Pembayaran sukses!');
                // Hapus session pay & cart via HTMX atau redirect
                window.location.href = '/mvcomp/payment/success';
            },
            onPending: function(result) {
                console.log('Pembayaran pending:', result);
                alert('Pembayaran pending. Silakan cek lagi.');
            },
            onError: function(result) {
                console.log('Pembayaran gagal:', result);
                alert('Pembayaran gagal!');
            },
            onClose: function() {
                alert('Anda menutup popup pembayaran');
            }
        });
    });
</script>