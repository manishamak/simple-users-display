<?php

declare(strict_types=1);

get_header(); ?>
<div class="container"> 
    <?php
    if (isset($userRows['is_error'])) {
        ?>
        <h4><?php
        //phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
           echo esc_html($userRows['is_error']); ?>
        </h4><?php
        //phpcs:disable Inpsyde.CodeQuality.NoElse
    } else {
        ?>
        <div class="table-responsive sud-table-wrap">
            <table cellpadding="0" cellspacing="0" width="100%" border="0" class="table">
                <tr>
                    <th><?php esc_html_e('User ID', 'simple-users-display'); ?></th>
                    <th><?php esc_html_e('Name', 'simple-users-display'); ?></th>
                    <th><?php esc_html_e('Username', 'simple-users-display'); ?></th>
                    <th><?php esc_html_e('Email', 'simple-users-display'); ?></th>
                </tr><?php
                foreach ($userRows as $key => $userRow) {
                    $viewUrl = home_url(sprintf(
                        "{$this->customEndPoint}/%s/%d",
                        'view',
                        $userRow->id
                    ));
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo esc_url($viewUrl); ?>">
                                <?php echo esc_html($userRow->id); ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo esc_url($viewUrl); ?>">
                                <?php echo esc_html($userRow->name); ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo esc_url($viewUrl); ?>">
                                <?php echo esc_html($userRow->username); ?>
                            </a>
                        </td>
                        <td><?php echo esc_html($userRow->email); ?></td>
                    </tr><?php
                } ?> 
            </table>
        </div><?php
    } ?>
</div>
<?php get_footer(); ?>
<?php
if ($this->isUserViewPage()) :
    $details = $this->sudShowUserDetails();
    $address = '';
    if (isset($details['address'])) {
        $address = [
            $details['address']->suite,
            $details['address']->street,
            $details['address']->city,
            $details['address']->zipcode,
        ];
        $address = implode(' ', $address);
    }
    ?>
    <div class="modal sud-userDetail-drawer fade sud-modal-open" id="sud-userDetail" tabindex="-1" 
        aria-labelledby="userDetail" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sud-api-status"></div>
                    <div class="user-detail">
                        <div class="sud-user-detail-list">
                            <ul>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Name', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field user-detail-list-field-lg" 
                                        id="sud-name"><?php
                                        echo esc_html(isset($details['name'])
                                            ? $details['name']
                                            : '—'); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Username', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-username"><?php
                                        echo esc_html(isset($details['username'])
                                            ? $details['username']
                                            : '—'); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Email', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-email"><?php
                                        echo esc_html(isset($details['email'])
                                            ? $details['email']
                                            : '—'); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Address', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-address"><?php
                                        echo esc_html(!empty($address)
                                            ? $address
                                            : '—'); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Phone', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-phone"><?php
                                        echo esc_html(isset($details['phone'])
                                            ? $details['phone']
                                            : '—'); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Website', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-website"><?php
                                        echo esc_html(isset($details['website'])
                                            ? $details['website']
                                            : '—'); ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <?php if (isset($details['address']) && !empty($details['address']->geo)) :
                            ?>
                        <div class="sud-user-detail-list two-col">
                            <div class="sud-user-detail-list-title"><?php esc_html_e('Geo', 'simple-users-display'); ?></div>
                            <ul>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Lat', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-lat"><?php
                                        echo esc_html(!empty($details['address']->geo->lat)
                                            ? $details['address']->geo->lat
                                            : '—'); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Lng', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-lng"><?php
                                        echo esc_html(!empty($details['address']->geo->lng)
                                            ? $details['address']->geo->lng
                                            : '—'); ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                            <?php
                        endif; ?>
                        <?php if (isset($details['company'])) :
                            ?>
                        <div class="sud-user-detail-list">
                            <div class="sud-user-detail-list-title"><?php esc_html_e('Company', 'simple-users-display'); ?></div>
                            <ul>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Name', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-company-name">
                                        <?php
                                        echo esc_html(!empty($details['company']->name)
                                            ? $details['company']->name
                                            : '—'); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="sud-user-detail-list-label"><?php esc_html_e('Catch Phrase', 'simple-users-display'); ?></div>
                                    <div class="sud-user-detail-list-field" id="sud-company-phrase">
                                        <?php
                                        echo esc_html(!empty($details['company']->catchPhrase)
                                            ? $details['company']->catchPhrase
                                            : '—'); ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                            <?php
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
endif;