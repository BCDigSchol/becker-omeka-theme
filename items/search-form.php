<?php
if (!empty($formActionUri)):
    $formAttributes['action'] = $formActionUri;
else:
    $formAttributes['action'] = url(
        [
            'controller' => 'items',
            'action'     => 'browse'
        ]
    );
endif;
$formAttributes['method'] = 'GET';


$search_relation_options = [
    'is exactly'       => __('is exactly'),
    'does not contain' => __('does not contain')
];

$select_whitelist = [
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

$battle_options = [
    ""                                                                                                                                                                                                                => "Select Below",
    "Atlanta Campaign, 1864"                                                                                                                                                                                          => "Atlanta Campaign, 1864 ",
    "Bayou Bourbeux, Battle of, La., 1863"                                                                                                                                                                            => "Bayou Bourbeux, Battle of, La., 1863 ",
    "Boydton Plank Road, Battle of, Va., 1864"                                                                                                                                                                        => "Boydton Plank Road, Battle of, Va., 1864 ",
    "Burnside's Expedition to North Carolina, 1862"                                                                                                                                                                   => "Burnside's Expedition to North Carolina, 1862 ",
    "Cedar Creek, Battle of, Va., 1864"                                                                                                                                                                               => "Cedar Creek, Battle of, Va., 1864 ",
    "Cedar Mountain, Battle of, Va., 1862"                                                                                                                                                                            => "Cedar Mountain, Battle of, Va., 1862 ",
    "Charleston (S.C.)--History--Siege, 1863"                                                                                                                                                                         => "Charleston (S.C.) Siege, 1863 ",
    "Fisher's Hill, Battle of, Va., 1864"                                                                                                                                                                             => "Fisher's Hill, Battle of, Va., 1864",
    "Fort Donelson, Battle of, Tenn., 1862"                                                                                                                                                                           => "Fort Donelson, Battle of, Tenn., 1862",
    "Fort Fisher (N.C. : Fort)--Siege, 1864-1865"                                                                                                                                                                     => "Fort Fisher (N.C. : Fort) Siege, 1864-1865 ",
    "Fort Henry, Battle of, Tenn., 1862"                                                                                                                                                                              => "Fort Henry, Battle of, Tenn., 1862",
    "Fort Macon (N.C.)--Siege, 1862"                                                                                                                                                                                  => "Fort Macon (N.C.) Siege, 1862",
    "Gettysburg, Battle of, Gettysburg, Pa., 1863"                                                                                                                                                                    => "Gettysburg, Battle of, Gettysburg, Pa., 1863 ",
    "Missionary Ridge, Battle of, Tenn., 1863"                                                                                                                                                                        => "Missionary Ridge, Battle of, Tenn., 1863",
    "Peeble's Farm, Battle of, Va., 1864"                                                                                                                                                                             => "Peeble's Farm, Battle of, Va., 1864",
    "Petersburg (Va.)--History--Siege, 1864-1865"                                                                                                                                                                     => "Petersburg (Va.) Siege, 1864-1865",
    "Petersburg Crater, Battle of, Va., 1864"                                                                                                                                                                         => "Petersburg Crater, Battle of, Va., 1864",
    "https://library.bc.edu/search?query=Port+Hudson&query_type=boolean&record_types%5B%5D=Item&record_types%5B%5D=File&record_types%5B%5D=Collection&record_types%5B%5D=SimplePagesPage&submit_search=Search" => "Port Hudson (La.) Siege, 1863",
    "Rich Mountain, Battle of, W. Va., 1861"                                                                                                                                                                          => "Rich Mountain, Battle of, W. Va., 1861",
    "Richmond (Va.)--History--Siege, 1864-1865--Pictorial works."                                                                                                                                                     => "Richmond (Va.) Siege, 1864-1865",
    "Roanoke Island (N.C.)--History--Capture, 1862"                                                                                                                                                                   => "Roanoke Island (N.C.) Capture, 1862",
    "Rowlett's Station, Battle of, Ky., 1861"                                                                                                                                                                         => "Rowlett's Station, Battle of, Ky., 1861",
    "Secessionville, Battle of, Secessionville, S.C., 1862"                                                                                                                                                           => "Secessionville, Battle of, Secessionville, S.C., 1862",
    "Shenandoah Valley Campaign, 1864 (August-November)"                                                                                                                                                              => "Shenandoah Valley Campaign, 1864 (August-November)",
    "Sherman's March to the Sea"                                                                                                                                                                                      => "Sherman's March to the Sea",
    "Shiloh, Battle of, Tenn., 1862"                                                                                                                                                                                  => "Shiloh, Battle of, Tenn., 1862",
    "Spotsylvania Court House, Battle of, Va., 1864"                                                                                                                                                                  => "Spotsylvania Court House, Battle of, Va., 1864",
    "West Virginia Campaign, 1861"                                                                                                                                                                                    => "West Virginia Campaign, 1861",
    "Wilderness, Battle of the, Va., 1864"                                                                                                                                                                            => "Wilderness, Battle of the, Va., 1864",
    "Winchester, 3rd Battle of, Winchester, Va., 1864"                                                                                                                                                                => "Winchester, 3rd Battle of, Winchester, Va., 1864",
]

?>

<form <?php echo tag_attributes($formAttributes); ?>>
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
                $search = [['field' => '', 'type' => '', 'value' => '']];
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
                        [
                            'title' => __('Search Joiner'),
                            'id'    => null,
                            'class' => 'advanced-search-joiner'
                        ],
                        [
                            'and' => __('AND'),
                            'or'  => __('OR'),
                        ]
                    );

                    // Filter out and rename element select options.
                    $original_select_options = get_table_options(
                        'Element',
                        null,
                        [
                            'record_types' => ['Item', 'All'],
                            'sort'         => 'orderBySet'
                        ]
                    );
                    $filtered_select_options = bc_filter_select_options($original_select_options, $select_whitelist);
                    $renamed_select_options = bc_rename_select_options($filtered_select_options);

                    echo $this->formSelect(
                        "advanced[$i][element_id]",
                        @$rows['element_id'],
                        [
                            'title' => __('Search Field'),
                            'id'    => null,
                            'class' => 'advanced-search-element'
                        ],
                        $renamed_select_options
                    );
                    echo $this->formSelect(
                        "advanced[$i][type]",
                        @$rows['type'],
                        [
                            'title' => __('Search Type'),
                            'id'    => null,
                            'class' => 'advanced-search-type'
                        ],
                        bc_label_table_options($search_relation_options)
                    );
                    echo $this->formText(
                        "advanced[$i][terms]",
                        @$rows['terms'],
                        [
                            'size'  => '20',
                            'title' => __('Search Terms'),
                            'id'    => null,
                            'class' => 'advanced-search-terms'
                        ]
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
                ['id' => 'collection-search'],
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
                    ['id' => 'user-search'],
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


    <div class="field">
        <?php echo $this->formLabel('tag-search', __('Search By Battle')); ?>
        <div class="inputs">
            <?php
            echo $this->formSelect(
                'battle',
                @$_REQUEST['collection'],
                ['id' => 'battle-search'],
                $battle_options
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
<?php echo js_tag('search-on-select'); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Omeka.Search.activateSearchButtons();

        // Activate dropdown redirects.

    });
</script>