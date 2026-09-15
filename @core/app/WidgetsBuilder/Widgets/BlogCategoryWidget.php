<?php


namespace App\WidgetsBuilder\Widgets;


use App\BlogCategory;
use App\EventsCategory;
use App\Language;
use App\WidgetsBuilder\WidgetBase;
use Illuminate\Support\Str;

class BlogCategoryWidget extends WidgetBase
{

    public function admin_render()
    {
        // TODO: Implement admin_render() method.
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        //render language tab
        $output .= $this->admin_language_tab();
        $output .= $this->admin_language_tab_start();

        $all_languages = Language::all();
        foreach ($all_languages as $key => $lang) {
            $output .= $this->admin_language_tab_content_start([
                'class' => $key == 0 ? 'tab-pane fade show active' : 'tab-pane fade',
                'id' => "nav-home-" . $lang->slug
            ]);
            $widget_title = $widget_saved_values['widget_title_' . $lang->slug] ?? '';
            $output .= '<div class="form-group"><input type="text" name="widget_title_' . $lang->slug . '" class="form-control" placeholder="' . __('Widget Title') . '" value="' . $widget_title . '"></div>';

            $output .= $this->admin_language_tab_content_end();
        }
        $output .= $this->admin_language_tab_end();
        //end multi langual tab option
        $post_items = $widget_saved_values['post_items'] ?? '';
        $output .= '<div class="form-group"><input type="text" name="post_items" class="form-control" placeholder="' . __('Post Items') . '" value="' . $post_items . '"></div>';

        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        // TODO: Implement frontend_render() method.
        $user_selected_language = get_user_lang();
        $widget_saved_values = $this->get_settings();

        $widget_title = $widget_saved_values['widget_title_' . $user_selected_language] ?? '';
        $post_items = $widget_saved_values['post_items'] ?? '';

        $blog_posts = BlogCategory::where(['lang' => $user_selected_language, 'status' => 'publish'])->orderBy('id', 'DESC')->take($post_items)->get();

        $output = $this->widget_before('widget_archive'); //render widget before content

        if (!empty($widget_title)) {
            $output .= '<h4 class="widget-title">' . $widget_title . '</h4>';
        }
        $output .= '<ul>';
        foreach ($blog_posts as $post) {
            $output .= '<li><a href="' . route('frontend.blog.category', ['id' => $post->id,'any' => Str::slug($post->name)]) . '"><i class="fas fa-chevron-right"></i> ' . $post->name . '</a></li>';
        }
        $output .= '</ul>';

        $output .= $this->widget_after(); // render widget after content

        return $output;
    }

    public function widget_title()
    {
        // TODO: Implement widget_title() method.
        return __('Blog Category');
    }
}