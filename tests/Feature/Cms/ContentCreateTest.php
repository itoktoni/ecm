<?php

use App\Models\Content;
use App\Models\Field;
use App\Models\Section;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::create([
        'name' => 'Test Editor',
        'email' => 'editor@test.com',
        'password' => bcrypt('password'),
        'role' => 'editor',
    ]);
    $this->actingAs($this->user);
});

it('creates a content entry with meta fields', function () {
    $type = Type::create([
        'name' => 'Post',
        'slug' => 'post',
        'type' => 'custom',
    ]);

    $field = Field::create([
        'name' => 'subtitle',
        'label' => 'Subtitle',
        'type' => 'text',
        'is_required' => false,
    ]);

    $section = Section::create([
        'name' => 'Post Meta',
        'content_type_id' => $type->id,
        'field_ids' => [$field->id],
        'is_active' => true,
    ]);

    $response = $this->post('/cms/content/create', [
        'content_type_id' => $type->id,
        'title' => 'Test Post',
        'slug' => 'test-post',
        'content' => 'Test content body',
        'status' => 'published',
        'meta' => [
            'subtitle' => 'A test subtitle',
        ],
        'active_sections' => [$section->id],
    ]);

    $response->assertSessionDoesntHaveErrors();

    $entry = Content::where('slug', 'test-post')->first();
    expect($entry)->not->toBeNull();
    expect($entry->title)->toBe('Test Post');
    expect($entry->content_type_id)->toBe($type->id);

    expect($entry->meta)->toHaveKey('subtitle');
    expect($entry->meta['subtitle'])->toBe('A test subtitle');

    expect($entry->active_sections)->toContain($section->id);
});

it('updates a content entry with new meta', function () {
    $type = Type::create([
        'name' => 'Post',
        'slug' => 'post',
        'type' => 'custom',
    ]);

    $field = Field::create([
        'name' => 'subtitle',
        'label' => 'Subtitle',
        'type' => 'text',
    ]);

    $section = Section::create([
        'name' => 'Post Meta',
        'content_type_id' => $type->id,
        'field_ids' => [$field->id],
        'is_active' => true,
    ]);

    $entry = Content::create([
        'content_type_id' => $type->id,
        'title' => 'Original',
        'slug' => 'original',
        'meta' => [
            'subtitle' => 'Old subtitle',
        ],
        'active_sections' => [$section->id],
    ]);

    $response = $this->post("/cms/content/update/{$entry->id}", [
        'title' => 'Updated',
        'meta' => [
            'subtitle' => 'New subtitle',
        ],
        'active_sections' => [$section->id],
    ]);

    $response->assertSessionDoesntHaveErrors();

    $entry->refresh();
    expect($entry->title)->toBe('Updated');

    expect($entry->meta)->toHaveKey('subtitle');
    expect($entry->meta['subtitle'])->toBe('New subtitle');
});

it('saves container meta as JSON', function () {
    $type = Type::create([
        'name' => 'Homepage',
        'slug' => 'homepage',
        'type' => 'custom',
    ]);

    $field = Field::create([
        'name' => 'page_builder',
        'label' => 'Page Builder',
        'type' => 'container',
        'mode' => 'multiple',
    ]);

    $section = Section::create([
        'name' => 'Builder',
        'content_type_id' => $type->id,
        'field_ids' => [$field->id],
        'is_active' => true,
    ]);

    $containerData = [
        ['_layout' => 'hero', 'title' => 'Welcome'],
        ['_layout' => 'cta', 'button_text' => 'Click'],
    ];

    $response = $this->post('/cms/content/create', [
        'content_type_id' => $type->id,
        'title' => 'Homepage',
        'slug' => 'homepage',
        'status' => 'published',
        'meta' => [
            'page_builder' => $containerData,
        ],
        'active_sections' => [$section->id],
    ]);

    $response->assertSessionDoesntHaveErrors();

    $entry = Content::where('slug', 'homepage')->first();
    expect($entry)->not->toBeNull();

    expect($entry->meta)->toHaveKey('page_builder');
    expect($entry->meta['page_builder'])->toBe($containerData);
});
