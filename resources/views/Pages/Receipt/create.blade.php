@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Receipt</h4>
    <a href="{{ route('receipts.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<x-card title="Generate Money Receipt">
    <form action="{{ route('receipts.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Select Invoice</label>
                <select name="invoice_id" id="invoice_id" class="form-control form-select-lg" required>
                    <option value="">-- Choose Invoice --</option>
                    @foreach($invoices as $inv)
                        <option value="{{ $inv->id }}" 
                            data-tenant-name="{{ $inv->tenant?->name }}"
                            data-tenant-id="{{ $inv->tenant_id }}"
                            data-lease-id="{{ $inv->lease_id }}"
                            {{-- Use the calculated balance_due from the controller --}}
                            data-amount="{{ $inv->balance_due }}">
                            INV-#{{ $inv->id }} | {{ $inv->tenant?->name }} (Due: {{ number_format($inv->balance_due, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Tenant Name</label>
                <input type="text" id="tenant_name_display" class="form-control bg-light" readonly placeholder="Auto-filled">
                <input type="hidden" name="tenant_id" id="tenant_id">
                <input type="hidden" name="lease_id" id="lease_id">
            </div>
        </div>

        <hr class="my-4">

        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <label class="form-label text-primary fw-bold">Invoice Total</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" id="invoice_total_display" class="form-control form-control-lg bg-soft-primary text-center fw-bold" readonly value="0.00">
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label text-success fw-bold">Amount to Pay</label>
                <div class="input-group">
                    <span class="input-group-text bg-success text-white">$</span>
                    <input type="number" step="0.01" name="receipt_total" id="receipt_total" class="form-control form-control-lg text-center fw-bold" placeholder="0.00" required>
                </div>
                <small class="text-muted">Enter the current payment amount</small>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label text-danger fw-bold">Remaining Due</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" id="due_amount_display" class="form-control form-control-lg bg-soft-danger text-center fw-bold text-danger" readonly value="0.00">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4 mb-3">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-control" required>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Bkash">Bkash</option>
                    <option value="Check">Check</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Transaction/Ref No.</label>
                <input type="text" name="transaction_no" class="form-control" placeholder="TrxID or Check No">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Remarks</label>
                <input type="text" name="remark" class="form-control" placeholder="Note for this payment">
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-1"></i> Save Receipt
            </button>
        </div>
    </form>
</x-card>

<script>
const invoiceSelect = document.getElementById('invoice_id');
const payInput = document.getElementById('receipt_total');
const totalDisplay = document.getElementById('invoice_total_display');
const dueDisplay = document.getElementById('due_amount_display');

// Function to update calculations
function calculateDue() {
    const total = parseFloat(totalDisplay.value) || 0;
    const paying = parseFloat(payInput.value) || 0;
    const due = total - paying;
    
    dueDisplay.value = due.toFixed(2);

    // Visual feedback: if due is 0, make it green, otherwise red
    if (due <= 0) {
        dueDisplay.classList.replace('text-danger', 'text-success');
        dueDisplay.classList.replace('bg-soft-danger', 'bg-soft-success');
    } else {
        dueDisplay.classList.replace('text-success', 'text-danger');
        dueDisplay.classList.replace('bg-soft-success', 'bg-soft-danger');
    }
}

// When Invoice is selected
invoiceSelect.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    
    if (selected.value !== "") {
        const amount = parseFloat(selected.getAttribute('data-amount')) || 0;

        document.getElementById('tenant_name_display').value = selected.getAttribute('data-tenant-name');
        document.getElementById('tenant_id').value = selected.getAttribute('data-tenant-id');
        document.getElementById('lease_id').value = selected.getAttribute('data-lease-id');
        
        totalDisplay.value = amount.toFixed(2);
        payInput.value = amount.toFixed(2); // Default to full payment
        
        calculateDue();
    } else {
        totalDisplay.value = "0.00";
        payInput.value = "";
        dueDisplay.value = "0.00";
    }
});

// When user types in the payment amount
payInput.addEventListener('input', calculateDue);
</script>
@endsection
{{-- Place the script here --}}
@section("js") 
<script>
    // Paste your code here
    document.getElementById('invoice_id').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        
        if (selected.value !== "") {
            const amountDue = parseFloat(selected.getAttribute('data-amount')) || 0;

            document.getElementById('tenant_name_display').value = selected.getAttribute('data-tenant-name');
            document.getElementById('invoice_total_display').value = amountDue.toFixed(2);
            
            const payInput = document.getElementById('receipt_total');
            payInput.value = amountDue.toFixed(2);
            
            updateBalance();
        }
    });

    document.getElementById('receipt_total').addEventListener('input', updateBalance);

    function updateBalance() {
        const totalOwed = parseFloat(document.getElementById('invoice_total_display').value) || 0;
        const payingNow = parseFloat(document.getElementById('receipt_total').value) || 0;
        const remaining = totalOwed - payingNow;

        const dueDisplay = document.getElementById('due_amount_display');
        if(dueDisplay) {
            dueDisplay.value = remaining.toFixed(2);
            dueDisplay.classList.toggle('text-danger', remaining > 0);
            dueDisplay.classList.toggle('text-success', remaining <= 0);
        }
    }
</script>
@endsection