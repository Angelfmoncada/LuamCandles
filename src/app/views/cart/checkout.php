<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body bg-light">
            <?php flash('order_error'); ?>
            <h2>Finalizar Compra</h2>
            <p>Total a pagar: <strong>L<?php echo number_format($data['total'], 2); ?> HNL</strong></p>

            <form action="<?php echo URLROOT; ?>/orders/checkout" method="post" id="checkout-form">
                <?php echo Csrf::field(); ?>

                <input type="hidden" name="payment_method" value="PayPal" id="payment_method">
                <input type="hidden" name="transaction_id" id="transaction_id">
                <input type="hidden" name="paypal_response" id="paypal_response">

                <div id="paypal-button-container" class="mb-3"></div>
            </form>
        </div>
    </div>
</div>

<?php

$totalUSD = number_format($data['total'] / 25, 2, '.', '');
?>
<?php if(defined('PAYPAL_API_KEY') && PAYPAL_API_KEY): ?>
<script src="https:
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {

            return fetch('<?php echo URLROOT; ?>/payments/create', {
                method: 'post',
                headers: {
                    'content-type': 'application/json'
                }
            }).then(function(res) {
                return res.json();
            }).then(function(serverData) {
                if (serverData.error) {
                    alert('Error: ' + serverData.error);
                    return Promise.reject();
                }

                return actions.order.create({
                    intent: 'CAPTURE',
                    application_context: {
                        shipping_preference: 'NO_SHIPPING'
                    },
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $totalUSD; ?>',
                            currency_code: 'USD'
                        },
                        description: 'Compra en Luam Candles'
                    }]
                });
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                console.log('PayPal transaction completed:', details);

                document.getElementById('transaction_id').value = details.id;
                document.getElementById('paypal_response').value = JSON.stringify(details);

                return fetch('<?php echo URLROOT; ?>/payments/capture', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderID: details.id,
                        details: details,
                        payer: details.payer,
                        status: details.status
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(serverRes) {
                    console.log('Backend capture response:', serverRes);

                    document.getElementById('checkout-form').submit();
                });
            });
        },
        onError: function (err) {
            console.error('PayPal Error:', err);
            alert('Hubo un error con el pago de PayPal. Por favor intenta de nuevo.');

            fetch('<?php echo URLROOT; ?>/orders/logPaypalError', {
                method: 'post',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify({
                    error: err,
                    message: 'PayPal button error',
                    timestamp: new Date().toISOString()
                })
            });
        },
        onCancel: function(data) {
            console.log('PayPal payment cancelled:', data);
            alert('Pago cancelado. Puedes intentar de nuevo cuando estés listo.');
        },
        style: {
            layout: 'vertical',
            color: 'gold',
            shape: 'rect',
            label: 'paypal',
            height: 45
        }
    }).render('
</script>
<?php endif; ?>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
