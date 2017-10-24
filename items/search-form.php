<?php
if (!empty($formActionUri)):
    $formAttributes['action'] = $formActionUri;
else:
    $formAttributes['action'] = url(
        array(
            'controller' => 'items',
            'action'     => 'browse'
        )
    );
endif;
$formAttributes['method'] = 'GET';
?>

    <form <?php echo tag_attributes($formAttributes); ?>>
        <div id="search-keywords" class="field">
            <?php echo $this->formLabel('keyword-search', __('Search for Keywords')); ?>
            <div class="inputs">
                <?php
                echo $this->formText(
                    'search',
                    @$_REQUEST['search'],
                    array('id' => 'keyword-search', 'size' => '40')
                );
                ?>
            </div>
        </div>
        <!--Changed field name-->
        <!-- again -->
        <div id="search-narrow-by-fields" class="field">
            <div class="label"><?php echo __('Search by'); ?></div>
            <div class="inputs">
                <?php
                // If the form has been submitted, retain the number of search
                // fields used and rebuild the form
                if (!empty($_GET['advanced'])) {
                    $search = $_GET['advanced'];
                } else {
                    $search = array(array('field' => '', 'type' => '', 'value' => ''));
                }

                //Here is where we actually build the search form
                foreach ($search as $i => $rows): ?>
                    <div class="search-entry">
                        <?php
                        //The POST looks like =>
                        // advanced[0] =>
                        //[field] = 'description'
                        //[type] = 'contains'
                        //[terms] = 'foobar'
                        //etc
                        echo $this->formSelect(
                            "advanced[$i][joiner]",
                            @$rows['joiner'],
                            array(
                                'title' => __("Search Joiner"),
                                'id'    => null,
                                'class' => 'advanced-search-joiner'
                            ),
                            array(
                                'and' => __('AND'),
                                'or'  => __('OR'),
                            )
                        );

                        // Filter out and rename element select options.
                        $original_select_options = get_table_options(
                            'Element',
                            null,
                            array(
                                'record_types' => array('Item', 'All'),
                                'sort'         => 'orderBySet'
                            )
                        );
                        $filtered_select_options = filter_select_options($original_select_options);
                        $renamed_select_options = rename_select_options($filtered_select_options);

                        echo $this->formSelect(
                            "advanced[$i][element_id]",
                            @$rows['element_id'],
                            array(
                                'title' => __("Search Field"),
                                'id'    => null,
                                'class' => 'advanced-search-element'
                            ),
                            $renamed_select_options
                        );
                        echo $this->formSelect(
                            "advanced[$i][type]",
                            @$rows['type'],
                            array(
                                'title' => __("Search Type"),
                                'id'    => null,
                                'class' => 'advanced-search-type'
                            ),
                            label_table_options(
                                array(
                                    'contains'         => __('contains'),
                                    'does not contain' => __('does not contain'),
                                    'is exactly'       => __('is exactly'),
                                    'is empty'         => __('is empty'),
                                    'is not empty'     => __('is not empty'),
                                    'starts with'      => __('starts with'),
                                    'ends with'        => __('ends with')
                                )
                            )
                        );
                        echo $this->formText(
                            "advanced[$i][terms]",
                            @$rows['terms'],
                            array(
                                'size'  => '20',
                                'title' => __("Search Terms"),
                                'id'    => null,
                                'class' => 'advanced-search-terms'
                            )
                        );
                        ?>
                        <button type="button" class="remove_search" disabled="disabled" style="display: none;"><?php echo __(
                                'Remove field'
                            ); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="add_search"><?php echo __('Add a Field'); ?></button>
        </div>

        <div class="field">
            <?php echo $this->formLabel('collection-search', __('Search By Collection')); ?>
            <div class="inputs">
                <?php
                echo $this->formSelect(
                    'collection',
                    @$_REQUEST['collection'],
                    array('id' => 'collection-search'),
                    get_table_options('Collection', null, array('include_no_collection' => true))
                );
                ?>
            </div>
        </div>

        <?php if (is_allowed('Users', 'browse')): ?>
            <div class="field">
                <?php
                echo $this->formLabel('user-search', __('Search By User')); ?>
                <div class="inputs">
                    <?php
                    echo $this->formSelect(
                        'user',
                        @$_REQUEST['user'],
                        array('id' => 'user-search'),
                        get_table_options('User')
                    );
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="field">
            <?php echo $this->formLabel('tag-search', __('Search By Tags')); ?>
            <div class="inputs">
                <?php
                echo $this->formText(
                    'tags',
                    @$_REQUEST['tags'],
                    array('size' => '40', 'id' => 'tag-search')
                );
                ?>
            </div>
        </div>


        <?php if (is_allowed('Items', 'showNotPublic')): ?>
            <div class="field">
                <?php echo $this->formLabel('public', __('Public/Non-Public')); ?>
                <div class="inputs">
                    <?php
                    echo $this->formSelect(
                        'public',
                        @$_REQUEST['public'],
                        array(),
                        label_table_options(
                            array(
                                '1' => __('Only Public Items'),
                                '0' => __('Only Non-Public Items')
                            )
                        )
                    );
                    ?>
                </div>
            </div>
        <?php endif; ?>

        </div>

        <?php fire_plugin_hook('public_items_search', array('view' => $this)); ?>
        <div>
            <?php if (!isset($buttonText)) {
                $buttonText = __('Search for items');
            } ?>
            <input type="submit" class="submit" name="submit_search" id="submit_search_advanced" value="<?php echo $buttonText ?>">
        </div>
    </form>

<?php echo js_tag('items-search'); ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            Omeka.Search.activateSearchButtons();
        });
    </script>

<?php

function filter_select_options($input)
{
    $whitelist = [
        'Select Below',
        'Has Part',
        'Description',
        'Coverage',
        'Extent',
        'Type',
        'Title',
        'Abstract',
        'Creator',
        'Date',
        'Subject',
        'Condition',
        'Place',
        'Medium',
        'Dimensions',
        'Genre',
        'Identifier'
    ];

    return array_filter(
        $input,
        function ($value) use ($whitelist) {
            return in_array(rtrim($value), $whitelist, true);
        }
    );
}

function rename_select_options($input)
{
    $rename_map = [
        'Has Part'    => 'Transcription',
        'Description' => 'Condition',
        'Coverage'    => 'Place',
        'Extent'      => 'Dimensions',
        'Type'        => 'Genre'
    ];

    $keys = array_keys($input);

    foreach ($keys as $key) {
        $value = $input[$key];
        $input[$key] = isset($rename_map[$value]) ? $rename_map[$value] : $value;
    }

    return $input;
}