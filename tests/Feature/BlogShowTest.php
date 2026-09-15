<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_and_show_render_with_article_schema(): void
    {
        $portfolio = Portfolio::query()->create([
            'category_label' => 'คาเฟ่แมว',
            'title' => 'เคสซ่อมคาเฟ่แมวสีลม',
            'slug' => 'vacuum-repair-cat-cafe-silom',
            'description' => 'เคสถอดล้าง 400 บาท',
            'status_label' => 'สำเร็จ',
            'sort_order' => 0,
            'is_active' => true,
            'map_coordinates' => '13.7265, 100.5230',
            'meta_title' => 'เคสจริง: ซ่อมเครื่องดูดฝุ่นคาเฟ่แมวย่านสีลม',
            'meta_description' => 'เคสจริงจากหน้างาน สีลม',
        ]);

        $blog = Blog::query()->create([
            'title' => 'เครื่องดูดฝุ่นไม่มีแรงดูด เกิดจากอะไร?',
            'slug' => 'vacuum-no-suction-fix',
            'primary_keyword' => 'เครื่องดูดฝุ่นไม่มีแรงดูด',
            'excerpt' => 'เช็คเอง 3 จุดก่อนส่งซ่อม',
            'body' => '<p>เนื้อหาทดสอบ</p><h2>เช็คเอง 3 จุด</h2><ol><li>เทถัง</li><li>ล้างฟิลเตอร์</li><li>ส่องท่อ</li></ol>',
            'author_name' => 'ช่างทดสอบ',
            'author_job_title' => 'ช่างซ่อมเครื่องใช้ไฟฟ้า',
            'author_description' => 'ประสบการณ์ 20 ปี',
            'faqs' => [
                [
                    'question' => 'ถอดล้างเครื่องดูดฝุ่น ราคาเท่าไหร่',
                    'answer' => 'เริ่มต้นที่ 300 บาท',
                ],
            ],
            'meta_title' => 'เครื่องดูดฝุ่นไม่มีแรงดูด เกิดจากอะไร?',
            'meta_description' => 'เช็คเอง 3 จุดจากเคสซ่อมจริง',
            'related_portfolio_id' => $portfolio->id,
            'is_published' => true,
            'published_at' => now()->subDay(),
            'content_updated_at' => now()->subDay(),
            'sort_order' => 1,
        ]);

        $portfolio->update(['related_blog_id' => $blog->id]);

        $index = $this->get('/blog');
        $index->assertOk();
        $index->assertSee('บทความซ่อมเครื่องดูดฝุ่น', false);
        $index->assertSee($blog->title, false);
        $index->assertSee('"@type":"ItemList"', false);

        $show = $this->get('/blog/'.$blog->slug);
        $show->assertOk();
        $show->assertSee($blog->title, false);
        $show->assertSee('ช่างทดสอบ', false);
        $show->assertSee('ถอดล้างเครื่องดูดฝุ่น ราคาเท่าไหร่', false);
        $show->assertSee('"@type":"Article"', false);
        $show->assertSee('"@type":"Person"', false);
        $show->assertSee('"@type":"FAQPage"', false);
        $show->assertSee('"@type":"BreadcrumbList"', false);

        $case = $this->get('/portfolio/'.$portfolio->slug);
        $case->assertOk();
        $case->assertSee($portfolio->title, false);
        $case->assertSee('"@type":"WebPage"', false);
        $case->assertSee($blog->title, false);
    }

    public function test_unpublished_blog_returns_404(): void
    {
        Blog::query()->create([
            'title' => 'ฉบับร่าง',
            'slug' => 'draft-post',
            'is_published' => false,
            'sort_order' => 0,
        ]);

        $this->get('/blog/draft-post')->assertNotFound();
    }
}
