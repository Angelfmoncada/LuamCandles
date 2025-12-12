<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="bi bi-credit-card me-2"></i>Finalizar Compra</h3>
            </div>
            <div class="card-body">
                <?php flash('order_error'); ?>

                <!-- Resumen del pedido -->
                <div class="alert alert-info mb-4">
                    <h5 class="alert-heading"><i class="bi bi-cart-check me-2"></i>Resumen del Pedido</h5>
                    <hr>
                    <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach($_SESSION['cart'] as $item): ?>
                                <li class="mb-2">
                                    <strong><?php echo $item['name']; ?></strong> x <?php echo $item['quantity']; ?>
                                    <span class="float-end">L<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <hr>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Total:</h4>
                        <h4 class="mb-0 text-primary"><strong>L<?php echo number_format($data['total'], 2); ?> HNL</strong></h4>
                    </div>
                    <small class="text-muted">Equivalente a: ~$<?php echo number_format($data['total'] / 25, 2); ?> USD</small>
                </div>

                <form action="<?php echo URLROOT; ?>/orders/checkout" method="post" id="checkout-form">
                    <?php echo Csrf::field(); ?>

                    <!-- Dirección de envío -->
                    <div class="mb-4">
                        <label for="address" class="form-label"><i class="bi bi-geo-alt me-1"></i>Dirección de Envío <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Ingresa tu dirección completa..." required></textarea>
                    </div>

                    <input type="hidden" name="payment_method" value="PayPal" id="payment_method">
                    <input type="hidden" name="transaction_id" id="transaction_id">
                    <input type="hidden" name="paypal_response" id="paypal_response">

                    <!-- Botones de PayPal -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-paypal me-1"></i>Método de Pago</label>
                        <div id="paypal-button-container"></div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Al completar el pago, serás redirigido a la confirmación de tu pedido.</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

$totalUSD = number_format($data['total'] / 25, 2, '.', '');
?>
<?php if(defined('PAYPAL_API_KEY') && PAYPAL_API_KEY): ?>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo PAYPAL_API_KEY; ?>&currency=USD"></script>
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            // Validar dirección antes de crear la orden
            var address = document.getElementById('address').value.trim();
            if (!address) {
                alert('Por favor ingresa tu dirección de envío antes de continuar con el pago.');
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
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                console.log('PayPal transaction completed:', details);

                document.getElementById('transaction_id').value = details.id;
                document.getElementById('paypal_response').value = JSON.stringify(details);

                fetch('<?php echo URLROOT; ?>/payments/capture', {
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
                }).catch(function(error) {
                    console.error('Error capturing payment:', error);
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
                    error: err ? err.toString() : 'Unknown error',
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
    }).render('#paypal-button-container')
</script>
<?php endif; ?>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
