<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompanyScope;
use App\Models\RMS\Company;

class InvoiceDetail extends Model
{
    use HasCompanyScope;
    protected $table = 'rms_invoice_details';

    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'invoice_id',
        'description',
        'price',
        'qty',
        'vat',
        'discount',
        'sort_order',
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'qty'      => 'decimal:2',
        'vat'      => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    // ── Helpers ───────────────────────────────────────────

    public function lineTotal(): float
    {
        return ($this->price * $this->qty) + $this->vat - $this->discount;
    }
}
