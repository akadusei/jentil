<?php
declare (strict_types = 1);

if (\post_password_required()) {
    return;
}

if (!\comments_open() && !\have_comments()) {
    return;
}

if (!\post_type_supports(\get_post_type(), 'comments')) {
    return;
} ?>

<div id="comments" class="site-comments">
    <?php if (\have_comments()) {
        $total_pages = \absint(\get_comment_pages_count());
        $comment_count = \absint(\get_comments_number());
        $title = \sprintf(
            \_n(
                '1 comment on %2$s',
                '%1$s comments on %2$s',
                $comment_count,
                'jentil'
            ),
            \number_format_i18n($comment_count),
            '&ldquo;'.\get_the_title().'&rdquo;'
        ); ?>

        <section id="comments-list">
            <h3 class="comments-title"><?= \apply_filters(
                'jentil_comments_title',
                $title
            ); ?></h3>

            <?php
            /**
             * Top navigation
             */
            if ($total_pages > 1 &&
                ($is_paged = \get_option('page_comments'))
            ) {
                $prev_label = \sanitize_text_field(
                    \apply_filters(
                        'jentil_pagination_prev_label',
                        \__('&larr; Previous', 'jentil'),
                        'comments'
                    )
                );

                $next_label = \sanitize_text_field(
                    \apply_filters(
                        'jentil_pagination_next_label',
                        \__('Next &rarr;', 'jentil'),
                        'comments'
                    )
                ); ?>

                <nav class="pagination top comments-pagination">
                    <?php \paginate_comments_links([
                        'prev_text' => $prev_label,
                        'next_text' => $next_label,
                    ]); ?>
                </nav>
            <?php }

            $comment_avatar_size = \absint(
                \apply_filters('jentil_comments_avatar_size', 40)
            );

            /**
             * List our comments
             */
            $comment_list_args = [
                'style' => 'ol',
                'avatar_size' => $comment_avatar_size,
            ]; ?>

            <ol class="commentlist">
                <?php \wp_list_comments($comment_list_args); ?>
            </ol>

            <?php
            /**
             * Bottom navigation
             */
            if ($total_pages > 1 && $is_paged) { ?>
                <nav class="pagination bottom comments-pagination">
                    <?php \paginate_comments_links([
                        'prev_text' => $prev_label,
                        'next_text' => $next_label,
                    ]); ?>
                </nav>
            <?php } ?>
        </section><!-- #comments-list -->

        <?php
        /**
         * If comments are closed and there are comments,
         * let's leave a little note, shall we?
         */
        if (!\comments_open()) { ?>
            <div class="comments-closed-text">
                <?= \sanitize_text_field(
                    \apply_filters(
                        'jentil_comments_closed_text',
                        \esc_html__('Comments are closed.', 'jentil'),
                        \get_comments_number()
                    )
                ); ?>
            </div>
        <?php }
    }

    \comment_form([
        'title_reply' => \esc_html__('Leave a comment', 'jentil')
    ]); ?>
</div><!-- #comments -->
