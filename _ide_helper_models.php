<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @mixin IdeHelperBaseModel
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel sortFields(array|string $fields)
 */
	class BaseModel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $parent_id
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $entries
 * @property-read int|null $entries_count
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withoutTrashed()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $content_type_id
 * @property string $title
 * @property string|null $slug
 * @property string|null $content
 * @property string|null $excerpt
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property int|null $author_id
 * @property string|null $featured_image
 * @property int $menu_order
 * @property array<array-key, mixed>|null $meta
 * @property array<array-key, mixed>|null $active_sections
 * @property array<array-key, mixed>|null $category_ids
 * @property array<array-key, mixed>|null $tag_ids
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $author
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read bool $is_published
 * @property-read \App\Models\Type|null $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereActiveSections($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereCategoryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereContentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereMenuOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereTagIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereUpdatedAt($value)
 */
	class Content extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $label
 * @property string|null $type
 * @property array<array-key, mixed>|null $config
 * @property array<array-key, mixed>|null $rules
 * @property bool|null $is_required
 * @property string|null $default_value
 * @property int $sort_order
 * @property int|null $parent_id
 * @property string|null $mode
 * @property int|null $min
 * @property int|null $max
 * @property bool|null $collapsed
 * @property bool|null $sortable
 * @property bool|null $cloneable
 * @property array<array-key, mixed>|null $layouts
 * @property int|null $type_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Field> $children
 * @property-read int|null $children_count
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\Field|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereCloneable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereCollapsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereLayouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereSortable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomField whereUpdatedAt($value)
 */
	class CustomField extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $customer_id
 * @property string $customer_nama
 * @property string|null $customer_telepon
 * @property string|null $customer_alamat
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $label
 * @property string|null $type
 * @property array<array-key, mixed>|null $config
 * @property array<array-key, mixed>|null $rules
 * @property bool|null $is_required
 * @property string|null $default_value
 * @property int $sort_order
 * @property int|null $parent_id
 * @property string|null $mode
 * @property int|null $min
 * @property int|null $max
 * @property bool|null $collapsed
 * @property bool|null $sortable
 * @property bool|null $cloneable
 * @property array<array-key, mixed>|null $layouts
 * @property int|null $type_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Field> $children
 * @property-read int|null $children_count
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read Field|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereCloneable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereCollapsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereLayouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereSortable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereUpdatedAt($value)
 */
	class Field extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $gudang_id
 * @property string $gudang_nama
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lokasi> $lokasi
 * @property-read int|null $lokasi_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang whereGudangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang whereGudangNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gudang whereUpdatedAt($value)
 */
	class Gudang extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $jasa_id
 * @property string $jasa_nama
 * @property string|null $jasa_icon
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read int $product_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa whereJasaIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa whereJasaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa whereJasaNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jasa whereUpdatedAt($value)
 */
	class Jasa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $out_code
 * @property string|null $out_reff
 * @property \Carbon\CarbonImmutable $out_tanggal
 * @property string $out_status
 * @property string|null $out_catatan
 * @property \Carbon\CarbonImmutable|null $out_created_at
 * @property int|null $out_created_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KeluarDetail> $details
 * @property-read int|null $details_count
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereOutCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereOutCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereOutCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereOutCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereOutReff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereOutStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereOutTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluar whereUpdatedAt($value)
 */
	class Keluar extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $out_detail_id
 * @property string $out_detail_code_keluar
 * @property int $out_detail_id_product
 * @property string $out_detail_code
 * @property int $out_detail_qty
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\Keluar $keluar
 * @property-read \App\Models\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KeluarRealisasi> $realisasi
 * @property-read int|null $realisasi_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail whereOutDetailCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail whereOutDetailCodeKeluar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail whereOutDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail whereOutDetailIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail whereOutDetailQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarDetail whereUpdatedAt($value)
 */
	class KeluarDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $out_realisasi_id
 * @property int $out_realisasi_id_detail
 * @property string $out_realisasi_code
 * @property int $out_realisasi_id_stock
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\KeluarDetail $detail
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\Stock $stock
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi whereOutRealisasiCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi whereOutRealisasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi whereOutRealisasiIdDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi whereOutRealisasiIdStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeluarRealisasi whereUpdatedAt($value)
 */
	class KeluarRealisasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $lokasi_id
 * @property string $lokasi_nama
 * @property int $lokasi_id_gudang
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read mixed $gudang_nama
 * @property-read \App\Models\Gudang $gudang
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Stock> $stock
 * @property-read int|null $stock_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereLokasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereLokasiIdGudang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereLokasiNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereUpdatedAt($value)
 */
	class Lokasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $in_detail_code
 * @property string|null $in_detail_reff
 * @property \Carbon\CarbonImmutable $in_detail_tanggal
 * @property string $in_detail_status
 * @property string|null $in_detail_catatan
 * @property \Carbon\CarbonImmutable|null $in_detail_created_at
 * @property int|null $in_detail_created_by
 * @property int $in_detail_id_product
 * @property int $in_detail_qty
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MasukRealisasi> $realisasi
 * @property-read int|null $realisasi_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailReff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereInDetailTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukDetail whereUpdatedAt($value)
 */
	class MasukDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $in_realisasi_id
 * @property string $in_realisasi_masuk_code
 * @property string $in_realisasi_code
 * @property int $in_realisasi_id_product
 * @property int $in_realisasi_qty
 * @property int|null $in_realisasi_group
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\MasukDetail $masukDetail
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi whereInRealisasiCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi whereInRealisasiGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi whereInRealisasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi whereInRealisasiIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi whereInRealisasiMasukCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi whereInRealisasiQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasukRealisasi whereUpdatedAt($value)
 */
	class MasukRealisasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $filename
 * @property string $original_filename
 * @property string $mime_type
 * @property int $size
 * @property string $disk
 * @property string $path
 * @property string|null $thumbnail_path
 * @property string|null $alt
 * @property string|null $title
 * @property string|null $caption
 * @property int|null $width
 * @property int|null $height
 * @property int|null $user_id
 * @property array<array-key, mixed>|null $meta
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read string $human_size
 * @property-read string|null $thumbnail
 * @property-read string $url
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media images()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media ofType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereOriginalFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereThumbnailPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media withoutTrashed()
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $location
 * @property array<array-key, mixed>|null $items
 * @property bool|null $is_active
 * @property int|null $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu withoutTrashed()
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $icon
 * @property string $icon_color
 * @property string $title
 * @property string|null $body
 * @property string|null $url
 * @property string $type
 * @property bool $read
 * @property array<array-key, mixed>|null $meta
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\User|null $has_user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIconColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $po_id
 * @property \Carbon\CarbonImmutable $po_tanggal
 * @property string $po_code
 * @property string $po_supplier
 * @property string $po_status
 * @property string|null $po_keterangan
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PoDetail> $details
 * @property-read int|null $details_count
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po wherePoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po wherePoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po wherePoKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po wherePoStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po wherePoSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po wherePoTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Po whereUpdatedAt($value)
 */
	class Po extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $po_detail_id
 * @property int $po_detail_id_po
 * @property int $po_detail_id_product
 * @property int $po_detail_qty
 * @property string $po_detail_code
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\Po $po
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail wherePoDetailCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail wherePoDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail wherePoDetailIdPo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail wherePoDetailIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail wherePoDetailQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PoDetail whereUpdatedAt($value)
 */
	class PoDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $product_id
 * @property string $product_nama
 * @property int|null $product_id_jasa
 * @property numeric|null $product_harga
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read mixed $jasa_nama
 * @property-read mixed $qty
 * @property-read mixed $tanggal
 * @property-read \App\Models\Jasa|null $jasa
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Stock> $stock
 * @property-read int|null $stock_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductIdJasa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $icon
 * @property int|null $content_type_id
 * @property array<array-key, mixed>|null $field_ids
 * @property int $sort_order
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read mixed $fields
 * @property-read \App\Models\Type|null $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereContentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereFieldIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedAt($value)
 */
	class Section extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $so_id
 * @property \Carbon\CarbonImmutable $so_tanggal
 * @property string $so_code
 * @property int $so_id_customer
 * @property string $so_status
 * @property string $so_pph
 * @property int $so_pph_rate
 * @property string $so_ppn
 * @property int $so_ppn_rate
 * @property numeric $so_discount
 * @property string|null $so_discount_note
 * @property string|null $so_keterangan
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SoDetail> $details
 * @property-read int|null $details_count
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read float $so_dpp
 * @property-read float $so_grand_total
 * @property-read float $so_pph_amount
 * @property-read float $so_ppn_amount
 * @property-read float $so_subtotal
 * @property-read string $so_total
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $petugas
 * @property-read int|null $petugas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoDiscountNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoIdCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoPph($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoPphRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoPpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoPpnRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereSoTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|So whereUpdatedAt($value)
 */
	class So extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $so_detail_id
 * @property int $so_detail_id_so
 * @property int $so_detail_id_product
 * @property int $so_detail_qty
 * @property numeric $so_detail_harga
 * @property string|null $so_detail_keterangan
 * @property string $so_detail_code
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property bool $so_detail_kaji_a
 * @property bool $so_detail_kaji_b
 * @property bool $so_detail_kaji_c
 * @property bool $so_detail_kaji_d
 * @property string|null $so_detail_kaji_keterangan
 * @property int|null $so_detail_id_teknisi
 * @property string $so_detail_kerja_status
 * @property \Carbon\CarbonImmutable|null $so_detail_kerja_ambil_at
 * @property \Carbon\CarbonImmutable|null $so_detail_kerja_selesai_at
 * @property array<array-key, mixed>|null $so_detail_lembar
 * @property string|null $so_detail_sertifikat_no
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\So $so
 * @property-read \App\Models\User|null $teknisi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailIdSo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailIdTeknisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKajiA($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKajiB($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKajiC($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKajiD($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKajiKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKerjaAmbilAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKerjaSelesaiAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKerjaStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailLembar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereSoDetailSertifikatNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoDetail whereUpdatedAt($value)
 */
	class SoDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $split_id
 * @property int $split_id_product
 * @property int $split_id_stock
 * @property int|null $split_id_reff
 * @property float $split_qty_new
 * @property float $split_qty_old
 * @property float $split_qty_waste
 * @property \Carbon\CarbonImmutable $split_tanggal
 * @property int|null $split_created_by
 * @property \Carbon\CarbonImmutable|null $split_created_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Stock $stock
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitIdReff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitIdStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitQtyNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitQtyOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitQtyWaste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereSplitTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Split whereUpdatedAt($value)
 */
	class Split extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $stock_id
 * @property string $stock_code
 * @property int $stock_id_product
 * @property int $stock_id_lokasi
 * @property int $stock_qty
 * @property \Carbon\CarbonImmutable|null $stock_expired_date
 * @property string|null $stock_reff
 * @property string $stock_type
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read mixed $lokasi_nama
 * @property-read mixed $product_nama
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KeluarRealisasi> $keluarRealisasi
 * @property-read int|null $keluar_realisasi_count
 * @property-read \App\Models\Lokasi $lokasi
 * @property-read \App\Models\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Split> $splits
 * @property-read int|null $splits_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock available()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereStockCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereStockExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereStockIdLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereStockIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereStockQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereStockReff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereStockType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock whereUpdatedAt($value)
 */
	class Stock extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $supplier_id
 * @property string|null $supplier_nama
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereSupplierNama($value)
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $entries
 * @property-read int|null $entries_count
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag withoutTrashed()
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string $type
 * @property string|null $description
 * @property array<array-key, mixed>|null $supports
 * @property bool $is_active
 * @property int|null $menu_position
 * @property string|null $menu_icon
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $contents
 * @property-read int|null $contents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Section> $fieldGroups
 * @property-read int|null $field_groups_count
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed|null $field_primary
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Section> $sections
 * @property-read int|null $sections_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereMenuIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereMenuPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereSupports($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereUpdatedAt($value)
 */
	class Type extends \Eloquent {}
}

namespace App\Models{
/**
 * @mixin IdeHelperUser
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property \Carbon\CarbonImmutable|null $verified_at
 * @property string|null $user_agama
 * @property string $role
 * @property int|null $subscribe
 * @property string|null $affiliate_code
 * @property string|null $affiliate_reff
 * @property int $affiliate_discount
 * @property string|null $rekening_nama
 * @property string|null $rekening_bank
 * @property string|null $rekening_nomor
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $field_key
 * @property-read mixed $field_name
 * @property-read mixed $field_primary
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAffiliateCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAffiliateDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAffiliateReff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRekeningBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRekeningNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRekeningNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereVerifiedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property string $channel
 * @property \Carbon\CarbonImmutable $expires_at
 * @property bool $used
 * @property string|null $created_at
 * @property-read \App\Models\User|null $has_user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerificationCode whereUserId($value)
 */
	class VerificationCode extends \Eloquent {}
}

