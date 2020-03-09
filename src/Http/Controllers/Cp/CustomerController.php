<?php

namespace DoubleThreeDigital\SimpleCommerce\Http\Controllers\Cp;

use DoubleThreeDigital\SimpleCommerce\Http\Requests\CustomerRequest;
use DoubleThreeDigital\SimpleCommerce\Models\Address;
use DoubleThreeDigital\SimpleCommerce\Models\Customer;
use DoubleThreeDigital\SimpleCommerce\Models\Order;
use Statamic\CP\Breadcrumbs;
use Statamic\Facades\Blueprint;
use Statamic\Http\Controllers\CP\CpController;

class CustomerController extends CpController
{
    public function index()
    {
        $this->authorize('view', Customer::class);

        $crumbs = Breadcrumbs::make([['text' => 'Simple Commerce']]);

        return view('commerce::cp.customers.index', [
            'crumbs'    => $crumbs,
            'customers' => Customer::paginate(config('statamic.cp.pagination_size')),
            'createUrl' => (new Customer())->createUrl(),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Customer::class);

        $crumbs = Breadcrumbs::make([['text' => 'Simple Commerce'], ['text' => 'Customers', 'url' => cp_route('customers.index')]]);

        $blueprint = Blueprint::find('simple-commerce/customer');

        $fields = $blueprint->fields();
        $fields = $fields->preProcess();

        return view('commerce::cp.customers.create', [
            'blueprint' => $blueprint->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
            'crumbs'    => $crumbs,
        ]);
    }

    public function store(CustomerRequest $request)
    {
        $this->authorize('create', Customer::class);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return [
            'redirect' => cp_route('customers.edit', [
                'customer' => $customer->uuid,
            ]),
        ];
    }

    public function edit($customer)
    {
        $this->authorize('update', $customer);

        $crumbs = Breadcrumbs::make([['text' => 'Simple Commerce'], ['text' => 'Customers', 'url' => cp_route('customers.index')]]);

        $blueprint = Blueprint::find('simple-commerce/customer');

        $fields = $blueprint->fields();
        $fields = $fields->preProcess();

        return view('commerce::cp.customers.edit', [
            'blueprint' => $blueprint->toPublishArray(),
            'values'    => $customer->toArray(),
            'meta'      => $fields->meta(),
            'crumbs'    => $crumbs,
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer): Customer
    {
        $this->authorize('update', $customer);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return $customer->refresh();
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->addresses()->delete();
        $customer->orders()->delete();
        $customer->delete();

        return back()->with('success', 'Customer has been deleted.');
    }
}
