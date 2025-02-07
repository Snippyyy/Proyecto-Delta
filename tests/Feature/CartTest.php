<?php

use App\Models\Product;
use App\Models\SellerCart;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('User see a message if he didnt have any product in his cart', function () {
    //Arrange
    $user = User::factory()->create();
    actingAs($user);
    //Act
    get(route('cart.index'))->assertSee('No tienes ningun carrito!');
    //Assert
});

it('User can add products to his cart', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(1))->create();

    actingAs($user);

    post(route('cart.store', $user2->products()->first()))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    $this->assertDatabaseHas('seller_carts', ['user_id' => $user->id]);
    $this->assertDatabaseHas('cart_items', ['seller_cart_id' => SellerCart::where('user_id', $user->id)->first()->id, 'product_id' => $user2->products()->first()->id]);

    get(route('cart.index'))->assertSee($user2->name);
    get(route('cart.show', $user->sellerCarts()->first()))->assertSee($user2->products()->first()->name);
});

it('User sees a seller cart if he add a product', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(1))->create();

    actingAs($user);

    post(route('cart.store', $user2->products->first()));

    $this->assertDatabaseHas('seller_carts', ['user_id' => $user->id, 'seller_id' => $user2->id]);

    get(route('cart.index'))
        ->assertSee($user2->name);
});

it('User see products in a seller cart', function () {

        $user = User::factory()->create();
        $user2 = User::factory()->has(Product::factory()->count(3))->create();

        actingAs($user);

        $products = $user2->products;

        foreach ($products as $product) {
            post(route('cart.store', $product));
            $this->assertDatabaseHas('cart_items', ['product_id' => $product->id]);
        }

        get(route('cart.show', $user->sellerCarts()->first()))
            ->assertSee([$products[0]->name, $products[1]->name, $products[2]->name]);
});

it('User can delete product from a seller cart', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->create();
    Product::factory(['name' => 'Producto A', 'seller_id' => $user2->id])->create();
    Product::factory(['name' => 'Producto B', 'seller_id' => $user2->id])->create();
    Product::factory(['name' => 'Producto C', 'seller_id' => $user2->id])->create();

    actingAs($user);

    $products = $user2->products;

    foreach ($products as $product) {
        post(route('cart.store', $product));
    }

    $cart = $user->sellerCarts()->first();

    $product = $products[0];

    get(route('cart.show', $cart))
        ->assertSee($product->name);

    delete(route('cart.destroy', [$cart, $product]))
        ->assertRedirect(route('cart.show', $cart))
        ->assertDontSee($product->name)
        ->assertSessionHas('status', 'Producto eliminado del carrito');

    $this->assertDatabaseMissing('cart_items', ['product_id' => $product->id]);
});

it('If user delete the last product of the cart the cart get automatically destroyed', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->create();
    Product::factory(['name' => 'Producto A', 'seller_id' => $user2->id])->create();

    actingAs($user);

    $product = $user2->products->first();

    post(route('cart.store', $product));

    $this->assertDatabaseHas('seller_carts', ['user_id' => $user->id]);
    $this->assertDatabaseHas('cart_items', ['product_id' => $product->id]);

    $cart = $user->sellerCarts()->first();

    delete(route('cart.destroy', [$cart, $product]));

    $this->assertDatabaseMissing('cart_items', ['product_id' => $product->id]);
    $this->assertDatabaseMissing('seller_carts', ['user_id' => $user->id]);

    get(route('cart.index'))
        ->assertSee('No tienes ningun carrito!');

});

it('User can buy the products from a seller cart', function () {

});

it('User will be advice if some article doesnt accept shipment', function () {

});

it('User cannot add products that owns', function () {

    $user = User::factory()->has(Product::factory())->create();

    actingAs($user);

    $product = $user->products->first();

    post(route('cart.store', $product))
        ->assertRedirect(route('product.show', $product))
        ->assertSessionHas('error', 'No puedes añadir tus propios productos al carrito');

});

it('User cannot add products that are already in his cart', function () {

    $user = User::factory()->create();

    $user2 = User::factory()->has(Product::factory())->create();

    actingAs($user);

    $product = $user2->products->first();

    post(route('cart.store', $product))
        ->assertRedirect(route('product.show', $product))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    post(route('cart.store', $product))
        ->assertRedirect(route('product.show', $product))
        ->assertSessionHas('error', 'Este producto ya se encuentra en el carrito');
});


it('User can use discount code and it aplies to the final price', function () {

});

it('Product info is in the seller cart show', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->create();

    $products = [Product::factory(
        [
            'shipment' => true
        ]
    )->create(['seller_id' => $user2->id]),
        Product::factory(
            [
                'shipment' => false
            ]
        )->create(['seller_id' => $user2->id]),
        Product::factory(
            [
                'shipment' => true
            ]
        )->create(['seller_id' => $user2->id])];

    actingAs($user);


    foreach ($products as $product) {
        post(route('cart.store', $product));
    }


    get(route('cart.show', $user->sellerCarts()->first()))
        ->assertSee([$products[0]->name, $products[1]->name, $products[2]->name])
        ->assertSee([$products[0]->price, $products[1]->price, $products[2]->price])
        ->assertSee([Str::limit($products[0]->description, 50), Str::limit($products[1]->description, 50), Str::limit($products[2]->description, 50)])
        ->assertSee([$products[0]->shipment ? 'Ok' : 'No', $products[1]->shipment ? 'Ok' : 'No', $products[2]->shipment ? 'Ok' : 'No']);
});

it('User can see the total price of the cart', function () {

    $user = User::factory()->create();

    $user2 = User::factory()->has(Product::factory(
        [
            'price' => 10
        ]
    )->count(3))->create();

    $products = $user2->products;
    actingAs($user);

    foreach ($products as $product) {
        post(route('cart.store', $product))
            ->assertSessionHas('status', 'Producto añadido al carrito');
        $this->assertDatabaseHas('cart_items', ['product_id' => $product->id]);
    }

    $cart = $user->sellerCarts()->first();

    get(route('cart.show', $cart))
        ->assertSee($cart->total_price);

});

it('User can see the total price of the cart with discount', function () {

});

it('Cart get destroyed automatically if there is no products in it', function () {

    $user = User::factory()->has(Product::factory())->create();

    $user2 = User::factory()->create();

    actingAs($user2);

    post(route('cart.store', $user->products->first()))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    $this->assertDatabaseHas('seller_carts', ['user_id' => $user2->id]);
    $this->assertDatabaseHas('cart_items', ['seller_cart_id' => SellerCart::where('user_id', $user2->id)->first()->id, 'product_id' => $user->products->first()->id]);

    actingAs($user);

    delete(route('product.delete', $user->products->first()));

    actingAs($user2);

    get(route('cart.index'))
        ->assertSeeText('No tienes ningun carrito!');
});

it('Guest can add products to his cart', function () {

    $user = User::factory()->has(Product::factory())->create();
    $product = $user->products->first();
    post(route('cart.store', $product))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    $this->assertDatabaseHas('seller_carts', ['token' => request()->cookie('guest_cart_token')]);
    $this->assertDatabaseHas('cart_items', ['seller_cart_id' => SellerCart::where('token', request()->cookie('guest_cart_token'))->first()->id, 'product_id' => $product->id]);
    get(route('cart.index'))
        ->assertOk()
        ->assertSee($product->user->name)
        ->assertSee($product->name);
});

it('Guest can delete items from a seller cart', function () {

    $user = User::factory()->has(Product::factory()->count(2))->create();
    $products = $user->products;


    foreach ($products as $product) {
        post(route('cart.store', $product))
            ->assertSessionHas('status', 'Producto añadido al carrito');
    }

    $cart = SellerCart::where('user_id', null)->first();


    // Simulación de token para Guest
    $token = Str::random(60);
    $cart->update(['token' => $token]);

    $product = $products[0];

    delete(route('cart.destroy', [$cart, $product]), [], ['Authorization' => 'Bearer ' . $token])
        ->assertRedirect(route('cart.show', $cart))
        ->assertSessionHas('status', 'Producto eliminado del carrito');

});

it('Guest cannot see the purchase button in seller cart', function () {

    $user = User::factory()->has(Product::factory())->create();
    $product = $user->products->first();
    post(route('cart.store', $product))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    get(route('cart.show', SellerCart::where('user_id', null)->first()))
        ->assertOk()
        ->assertDontSee('Comprar');

});

it('Guest cannot access to checkout', function () {

    $user = User::factory()->has(Product::factory([
        'status' => 'published'
    ]))->create();
    $product = $user->products->first();
    post(route('cart.store', $product))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    get(route('cart.show', SellerCart::where('user_id', null)->first()))
        ->assertOk()
        ->assertDontSee('Comprar');

    post(route('cart.checkout', SellerCart::where('user_id', null)->first()))
        ->assertRedirect('/login');
});

it('Guest Cart gets automatically destroyed after 30 days with no update', function () {


    $product = Product::factory()->create();

    post(route('cart.store', $product))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    $this->assertDatabaseHas('seller_carts'); //Comprueba que al menos haya 1 registro

    $cart = SellerCart::where('user_id', null)->first();
    $cart['updated_at'] = Carbon::now()->subDays(31);
    $cart->save();




    Artisan::call('cart:clean');

    get(route('cart.index'))
        ->assertSee('No tienes ningun carrito!');

});

