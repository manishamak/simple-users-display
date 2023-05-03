<?php

declare(strict_types=1);

namespace SimpleUsers\Common;

/**
 * WP rewrite rules.
 */
class RegisterRewriteRules
{
    /**
     * Rewrite slug
     *
     * @var string $rewriteSlug
     */
    private $rewriteSlug;

    /**
     * Register rewrite rules.
     *
     * @param string $customEndPoint  Rewrite endpoint.
     */
    public function __construct(string $customEndPoint = '')
    {
        $this->rewriteSlug = $customEndPoint;
        add_action('init', [$this, 'registerCustomEndpoint']);
        add_filter('query_vars', [$this, 'addQueryVars']);
    }

    /**
     * Set custom query vars.
     *
     * @param array  $query_vars  Query.
     *
     * @return array
     */
    public function addQueryVars(array $queryVars): array
    {
        $queryVars[] = 'action';
        $queryVars[] = 'user_id';
        return $queryVars;
    }

    /**
     * Register custom URL endpoint.
     */
    public function registerCustomEndpoint()
    {
        add_rewrite_rule("{$this->rewriteSlug}[/]?$", 'index.php?action=sud_user_list', 'top');
        add_rewrite_rule("{$this->rewriteSlug}/view/([0-9-]+)[/]?$", 'index.php?action=sud_user_list&user_id=$matches[1]', 'top'); // phpcs:ignore Inpsyde.CodeQuality.LineLength.TooLong
    }
}
