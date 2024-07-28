<style>
    .content-title {
        display: flex;
        padding: 0 10px;
        justify-content: center;
        align-items: center;
        padding-bottom: 20px;
    }
    .title {
        font-size: 50px;
        font-weight: bold;
        color: #107e5b;
        border-bottom: 0.5px solid #82b5a5;
        width: 100%;
        text-align: center
    }

    .content-body {
        display: flex;
        justify-content: space-evenly;
        align-items: baseline;
        flex-direction: row;
        padding: 20px;
    }

    .content-paid,
    .content-desc {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .content-value {
        font-size: 35px;
        color: #db4a4a;
        font-weight: 500;
        font-family: sans-serif, Arial;
        text-align: center
    }

    .success {
        color: #107e5b !important;
    }

    .info {
        color: #10437e !important;
    }

    .content-div-subtitle {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .content-subtitle {
        font-size: 12px;
        color: #bebebe;
    }

    .content-subtitle-date {
        font-size: 10px;
        color: #e4e4e4;
    }
</style>
<div>
    <div class="content-title">
        <h2 class="title">{{ $expense->title }}</h2>
    </div>
    <div class="content-body">
        <div class="content-desc">
            <p class="content-value info">R$ {{ $expense->amount }}</p>
            <p class="content-subtitle">Valor total</p>
        </div>
        <div class="paid-content">
            <p class="content-value success">R$ {{ $expense->amount_paid }}</p>
            <div class="content-div-subtitle">
                <p class="content-subtitle">Valor pago</p>
                <p class="content-subtitle-date">Data de pagamento {{ $expense->paid_date }}</p>
            </div>
        </div>
        <div class="paid-content">
            <p class="content-value">R$ {{ $expense->amount - $expense->amount_paid }}</p>
            <div class="content-div-subtitle">
                <p class="content-subtitle">Valor a pagar</p>
            </div>
        </div>
    </div>
</div>
