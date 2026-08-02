<?php

namespace Tests\Unit\Services;

use App\Models\Content;
use App\Models\Field;
use App\Models\Section;
use App\Models\Type;
use App\Services\ContentEntryExtractor;
use Tests\TestCase;

class ContentEntryExtractorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->type = Type::create([
            'name' => 'Homepage',
            'slug' => 'homepage',
            'type' => 'custom',
        ]);

        $slide = Field::create([
            'name' => 'carousel',
            'label' => 'Carousel',
            'type' => 'container',
            'mode' => 'multiple',
            'sort_order' => 1,
        ]);

        $text = Field::create([
            'name' => 'text',
            'label' => 'Text',
            'type' => 'text',
            'parent_id' => $slide->id,
            'sort_order' => 1,
        ]);

        $image = Field::create([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'parent_id' => $slide->id,
            'sort_order' => 2,
        ]);

        $button = Field::create([
            'name' => 'button',
            'label' => 'Button',
            'type' => 'text',
            'parent_id' => $slide->id,
            'sort_order' => 3,
        ]);

        $this->section = Section::create([
            'name' => 'slider',
            'content_type_id' => $this->type->id,
            'field_ids' => [$slide->id],
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->entry = Content::create([
            'content_type_id' => $this->type->id,
            'title' => 'Homepage',
            'slug' => 'homepage',
            'status' => 'published',
            'meta' => [
                'slider' => [
                    ['text' => 'Slide 1', 'image' => '/img/1.jpg', 'button' => 'Learn'],
                    ['text' => 'Slide 2', 'image' => '/img/2.jpg', 'button' => 'Go'],
                ],
            ],
        ]);
    }

    public function test_extract_returns_sections_with_field_values()
    {
        $result = ContentEntryExtractor::extract($this->entry);

        $this->assertArrayHasKey('sections', $result);
        $this->assertArrayHasKey('slider', $result['sections']);
        $this->assertArrayHasKey('carousel', $result['sections']['slider']);
        $this->assertIsArray($result['sections']['slider']['carousel']);
    }

    public function test_extract_container_field_returns_array_of_items()
    {
        $result = ContentEntryExtractor::extract($this->entry);

        $carousel = $result['sections']['slider']['carousel'];
        $this->assertIsArray($carousel);
        $this->assertArrayHasKey('text', $carousel[0]);
        $this->assertArrayHasKey('image', $carousel[0]);
        $this->assertArrayHasKey('button', $carousel[0]);
    }

    public function test_form_schema_returns_sections_with_fields()
    {
        $result = ContentEntryExtractor::formSchema($this->entry);

        $this->assertArrayHasKey('sections', $result);
        $this->assertArrayHasKey('slider', $result['sections']);
        $this->assertArrayHasKey('fields', $result['sections']['slider']);
    }
}
