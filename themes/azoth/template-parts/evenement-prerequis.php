<?php
$terms = get_the_terms($post->ID, 'prerequis');
if ($terms): ?>
    <div class="post-taxonomies">
        <p> Prérequis :
            <?php if (count($terms) === 1):
                echo $terms[0]->name;
            else:
                foreach ($terms as $term): ?>
                </p>
                <p>
                    <?= $term->name; ?>
                <?php endforeach;
            endif; ?>
        </p>
    </div>
<?php endif;