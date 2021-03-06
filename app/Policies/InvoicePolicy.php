<?php


namespace App\Policies;

use App\Invoice;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Admin has full privileges when invoicing.
     *
     * @param \App\User $user
     * @param string $ability
     * @return mixed
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can an invoice.
     *
     * @param  Invoice $invoice
     * @return mixed
     */
    public function view(User $user, Invoice $invoice)
    {
        if ($invoice->client->user_id === $user->id) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the invoice index.
     *
     * @param  User $user
     * @return mixed
     */
    public function index(User $user)
    {
        if (\App\InvoiceClient::whereUserId($user->id)->exists()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create an invoice.
     *
     * @param  User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update an invoice.
     *
     * @param  User $user
     * @param  Invoice $invoice
     * @return mixed
     */
    public function update(User $user, $invoice)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete an invoice.
     *
     * @param  User $user
     * @param  Invoice $invoice
     * @return mixed
     */
    public function delete(User $user, $invoice)
    {
        return $user->isAdmin();
    }
}
