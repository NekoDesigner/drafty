# Drafty 

See the complete documentation on [nekodev packages website](https://packages.nekodev.fr/laravel/drafty).

Compatiable with [Spatie/MediaLibrary package v8](https://docs.spatie.be/laravel-medialibrary/v8/).

## Quick Start

### Installation

install package via composer
```shell
composer install nekodev/drafty
```

Add provider from *config/app.php*
```php
'providers' => [
    ...
    Nekodev\Drafty\DraftyServiceProvider::class,
    ...
],
```

Launch migrations
```shell
php artisan migrate
```
This command will create `drafts` table from your database. This table will manage all your drafts data.

Prepare your model
```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Nekodev\Drafty\Traits\Draftable;
use Nekodev\Drafty\Interfaces\HasDraftable;

class Post extends Model implements HasDraftable
{
    use Draftable;

    /**
     * Get the post's draft.
     */
    public function draft()
    {
        return $this->morphOne('Nekodev\Drafty\Models\Draft', 'draftable');
    }
}
```

Draft use polymorphique relations. You must implements HasDraftable interface and use `draft()` method. This method will return a Draft class model.

### Basic usage

Example from controller
```php
private function saveDraftPost(Request $request, Post $post)
{
    // Update Model data
    $post->title = $request->title;
    $post->content = $request->content;

    // create or update draft and return it 
    $data = $post->saveAsDraft();

    return $data;
}
```

When `$post->save()` method will call, draft will automatically deleted. You **must** call `$post->applyDraft()` **before** calling `save` method.

## Draft customization

You can create your owns Drafts Models. `php artisan make:draft <draft name>`

```php
php artisan make:draft PostDraft
```

This command will create a draft méthod from *app/Drafts* directory.

```php
namespace App\Drafts;

use Nekodev\Drafty\Models\Draft as DraftModel;

class PostDraft extends DraftModel
{

}
```

### Example usage
If you whant add some relationship :

**POST MODEL**
```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Nekodev\Drafty\Traits\Draftable;
use Nekodev\Drafty\Interfaces\HasDraftable;
use App\Category;

class Post extends Model implements HasDraftable
{
    use Draftable;

    public $fillable = [ 'title', 'content' ];

    /**
     * Get the post's draft.
     */
    public function draft()
    {
        return $this->morphOne('App\Drafts\PostDraft', 'draftable');
    }

    /**
     * Return categories from post
     */
    public function categories()
    {
        return $this->morphToMany('App\Category', 'categorable');
    }
}
```

**CUSTOM DRAFT MODEL**
```php
namespace App\Drafts;

use Nekodev\Drafty\Models\Draft as DraftModel;
use App\Category;

class PostDraft extends DraftModel
{
    /**
     * Return categories from draft
     */
    public function categories()
    {
        return $this->morphToMany('App\Category', 'categorable');
    }
}
```

You must create polymorphic relation from your model that can have draft.

## Usage with Spatie Media Livrary

**POST MODEL**
```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Nekodev\Drafty\Traits\Draftable;
use Nekodev\Drafty\Interfaces\HasDraftable;
use App\Category;

class Post extends Model implements HasMedia, HasDraftable
{
    use Draftable;
    use InteractsWithMedia;

    public $fillable = [ 'title', 'content' ];

    /**
     * Get the post's draft.
     */
    public function draft()
    {
        return $this->morphOne('App\Drafts\PostDraft', 'draftable');
    }
}
```

**CUSTOM DRAFT MODEL**
```php
namespace App\Drafts;

use Nekodev\Drafty\Models\Draft as DraftModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PostDraft extends DraftModel implements HasMedia
{
    use InteractsWithMedia;
}
```

On apply `save` method from `Post` model, all media collection from Post model are remove and replace by `PostDraft` model collection.

## Credit
![alt text](https://avatars3.githubusercontent.com/u/18350326?s=25&u=3389cb6f56e0c28522e2b5e6a614ae207339f495&v=4 "Logo Title Text 1")
 [@nekodesigner (NekoDev)](https://github.com/NekoDesigner) - Tahar CHIBANE | FullStack Developer

 Enjoy !! :smiley:
