<?php
add_action('init', function () {


    $courses = [

        ['Business','Freelance','How to Start Freelancing from Scratch','Beginner'],
        ['Business','Freelance','Where to Find Clients','Beginner'],
        ['Business','Freelance','How to Communicate with Clients','Beginner'],
        ['Business','Freelance','How to Increase Freelance Income','Intermediate'],
        ['Business','Monetization','Ways to Monetize Your Skills','Beginner'],
        ['Business','Monetization','How to Create a Paid Product','Intermediate'],

        ['IT','AI','Introduction to ChatGPT','Beginner'],
        ['IT','AI','ChatGPT for Productivity','Beginner'],
        ['IT','AI','ChatGPT for Making Money','Intermediate'],

        ['Tools','Notion','Notion Basics','Beginner'],
        ['Tools','Notion','Notion for Task Management','Beginner'],
        ['Tools','Automation','Automation Basics (Zapier / Make)','Intermediate'],

        ['Marketing','Digital Marketing','Introduction to Digital Marketing','Beginner'],
        ['Marketing','SMM','SMM Basics','Beginner'],
        ['Marketing','SMM','Instagram Marketing','Beginner'],
        ['Marketing','Content Marketing','Content Marketing Basics','Beginner'],
        ['Marketing','Copywriting','Copywriting Basics','Beginner'],
        ['Marketing','Copywriting','Sales Copywriting','Intermediate'],

        ['Personal Development','Productivity','Time Management Basics','Beginner'],
        ['Personal Development','Productivity','How to Stop Procrastinating','Beginner'],
        ['Personal Development','Learning','How to Learn Effectively','Beginner'],

        ['IT','Web Development','HTML Basics','Beginner'],
        ['IT','Web Development','CSS Basics','Beginner'],
        ['IT','Web Development','JavaScript Basics','Beginner'],
        ['IT','Web Development','How to Build a Website from Scratch','Intermediate'],

        ['IT','Programming','Introduction to Python','Beginner'],
        ['IT','Programming','Python for Automation','Intermediate'],

        ['Finance','Financial Literacy','Financial Literacy Basics','Beginner'],
        ['Finance','Personal Finance','How to Manage Your Budget','Beginner'],
        ['Finance','Investing','Investing Basics','Beginner'],
        ['Finance','Crypto','Introduction to Cryptocurrency','Beginner'],

        ['Career','Resume','How to Write a Resume','Beginner'],
        ['Career','Interviews','How to Pass a Job Interview','Beginner'],
        ['Career','Job Search','How to Get Your First Job','Beginner'],
        ['Career','Growth','How to Get Promoted','Intermediate'],
        ['Career','Remote Work','How to Start Working Remotely','Beginner'],

        ['Soft Skills','Communication','Communication Skills Basics','Beginner'],
        ['Soft Skills','Public Speaking','Public Speaking Basics','Beginner'],
        ['Soft Skills','EQ','Emotional Intelligence','Beginner'],
        ['Soft Skills','Leadership','Leadership Basics','Intermediate'],

        ['Content Creation','YouTube','How to Start a YouTube Channel','Beginner'],
        ['Content Creation','TikTok','TikTok for Beginners','Beginner'],
        ['Content Creation','Creator Economy','How to Become a Content Creator','Beginner'],
        ['Content Creation','Video Editing','Video Editing Basics','Beginner'],
        ['Content Creation','Personal Brand','Personal Branding from Scratch','Beginner'],

        ['Practical Skills','Excel','Excel / Google Sheets Basics','Beginner'],
        ['Practical Skills','Excel','Advanced Excel','Intermediate'],

        ['Data & Analytics','Data Analysis','Data Analysis Basics','Beginner'],
        ['Data & Analytics','SQL','SQL Basics','Beginner'],

        ['E-commerce','Online Store','How to Launch an Online Store','Beginner'],

        ['Business','Startups','How to Find a Startup Idea','Beginner'],
        ['Business','Startups','How to Build an MVP','Intermediate'],
        ['Business','Online Business','How to Choose a Niche','Beginner'],
        ['Business','Online Business','Scaling an Online Business','Advanced'],

        ['Marketing','SEO','SEO Basics','Beginner'],
        ['Marketing','SEO','Technical SEO','Intermediate'],
        ['Marketing','Ads','Paid Ads Basics','Beginner'],
        ['Marketing','Ads','Ad Creatives','Intermediate'],
        ['Marketing','Email Marketing','Email Marketing Basics','Beginner'],
        ['Marketing','Email Marketing','Email Automation','Intermediate'],

        ['IT','Cybersecurity','Cybersecurity Basics','Beginner'],
        ['IT','DevOps','Introduction to DevOps','Beginner'],
        ['IT','DevOps','Docker for Beginners','Intermediate'],
        ['IT','No-code','No-code Website Building','Beginner'],
        ['IT','No-code','No-code Automation','Intermediate'],

        ['Design','UX/UI','UX/UI Basics','Beginner'],
        ['Design','Graphic Design','Graphic Design Basics','Beginner'],
        ['Design','Branding','Logo Design','Beginner'],
        ['Design','Video','Video Editing for Social Media','Beginner'],
        ['Design','Animation','Animation Basics','Beginner'],

        ['Finance','Investing','Long-term Investing','Intermediate'],
        ['Finance','Crypto','Crypto Security','Intermediate'],

        ['Career','LinkedIn','LinkedIn for Job Search','Beginner'],
        ['Career','Skills','Soft Skills for Career Growth','Beginner'],

        ['Soft Skills','Negotiation','Negotiation Basics','Beginner'],
        ['Soft Skills','Teamwork','Teamwork Skills','Beginner'],

        ['Content Creation','Blogging','How to Start a Blog','Beginner'],
        ['Content Creation','Podcasts','How to Start a Podcast','Beginner'],
        ['Content Creation','Video','Advanced Video Editing','Intermediate'],
        ['Content Creation','Monetization','Content Monetization','Intermediate'],

        ['Practical Skills','Documents','Working with Documents','Beginner'],
        ['Practical Skills','Presentations','Presentation Skills','Beginner'],

        ['Data & Analytics','BI','Introduction to BI Tools','Beginner'],
        ['Data & Analytics','Excel','Excel for Data Analysis','Intermediate'],

        ['E-commerce','Shopify','Shopify Basics','Beginner'],
        ['E-commerce','Dropshipping','Dropshipping Basics','Beginner'],
        ['E-commerce','Amazon','Selling on Amazon','Intermediate'],

        ['Tools','Figma','Figma Basics','Beginner'],
        ['Tools','Photoshop','Photoshop Basics','Beginner'],
        ['Tools','AI','Prompt Engineering','Intermediate'],
        ['Tools','AI','AI Automation','Advanced'],

        ['Personal Development','Goals','Goal Setting','Beginner'],
        ['Personal Development','Habits','Building Habits','Beginner'],
        ['Personal Development','Discipline','Self-Discipline','Intermediate'],

        ['Health','Sleep','Sleep Optimization','Beginner'],
        ['Health','Focus','Deep Work','Intermediate'],
        ['Health','Stress','Stress Management','Beginner'],

        ['Languages','English','English for Beginners','Beginner'],
        ['Languages','English','Conversational English','Beginner'],
        ['Languages','Business English','Business English','Intermediate']

    ];

    foreach ($courses as $course) {
         [$category, $subcategory, $title, $level] = $course;

         // 2. BETTER DUPLICATE CHECK (get_page_by_title is outdated in newer WP)
         $existing = new WP_Query([
             'post_type'      => 'course',
             'title'          => $title,
             'posts_per_page' => 1,
             'fields'         => 'ids'
         ]);

         if (!empty($existing->posts)) {
             continue; // Course already exists, skip it
         }

         // 3. PARENT TERM
         $parent = term_exists($category, 'course_category');

         if (!$parent) {
             $parent = wp_insert_term($category, 'course_category');

             // Error handling
             if (is_wp_error($parent)) {
                 continue;
             }
             $parent_id = $parent['term_id'];
         } else {
             $parent_id = is_array($parent) ? $parent['term_id'] : $parent;
         }

         // 4. CHILD TERM
         $child = get_terms([
             'taxonomy'   => 'course_category',
             'hide_empty' => false,
             'parent'     => $parent_id,
             'name'       => $subcategory
         ]);

         if (empty($child) || is_wp_error($child)) {
             $child = wp_insert_term($subcategory, 'course_category', [
                 'parent' => $parent_id
             ]);

             // Error handling
             if (is_wp_error($child)) {
                 continue;
             }
             $child_id = $child['term_id'];
         } else {
             $child_id = $child[0]->term_id;
         }

         // 5. INSERT POST
         $post_id = wp_insert_post([
             'post_title'  => $title,
             'post_type'   => 'course',
             'post_status' => 'publish'
         ]);

         // Error handling: Stop if the post failed to insert
         if (is_wp_error($post_id)) {
             continue;
         }

         // 6. ASSIGN TERM
         wp_set_object_terms($post_id, [$child_id], 'course_category');

         // 7. UPDATE ACF FIELD
         // Note: Ensure your ACF field name is exactly 'level'
         update_field('level', $level, $post_id);
     }


});

$courses = get_posts([
    'post_type'      => 'course',
    'posts_per_page' => -1,
    'post_status'    => 'publish'
]);

if (!$courses) {
    return;
}

foreach ($courses as $course) {

    // 4.1 - 5.0
    $rating = number_format(
        mt_rand(41,50) / 10,
        1
    );

    // hours
    $duration = mt_rand(2, 24);

    // lessons
    $lessons_count = mt_rand(8, 60);


    update_field(
        'rating',
        $rating,
        $course->ID
    );

    update_field(
        'duration',
        $duration,
        $course->ID
    );

    update_field(
        'lessons_count',
        $lessons_count,
        $course->ID
    );
}

$thumbnail_id = 355;

$courses = get_posts([
    'post_type' => 'course',
    'posts_per_page' => -1,
    'post_status' => 'publish'
]);

foreach ($courses as $course) {

    set_post_thumbnail(
        $course->ID,
        $thumbnail_id
    );

}

$courses = get_posts([
    'post_type' => 'course',
    'posts_per_page' => -1,
    'post_status' => 'publish'
]);

foreach ($courses as $course) {

    wp_update_post([
        'ID' => $course->ID,
        'post_excerpt' => 'Test excerpt'
    ]);

}