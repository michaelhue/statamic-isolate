<?php
/**
 * Plugin_isolate
 *
 * Isolates content from context to prevent data overrides and inheritance.
 *
 * @author Michael Hüneburg <hello@michaelhue.com>
 * @link https://github.com/michaelhue/statamic-isolate
 */
class Plugin_isolate extends Plugin
{
    /**
     * Isolates content data from contextual data (i.e. only content data is
     * available inside the tag pair).
     *
     * Content is queried based on the `url`
     * context parameter, so you can use this tag inside loops (e.g. entries:listing).
     * You can also define exceptions using the `except` parameter and the names
     * of data to pull in from context, separated by |.
     *
     * Parameters:
     *
     *   - except: A string of one or more variable names (separated by |) that
     *             will be pulled in from the context.
     *
     * Example:
     *
     *   {{ isolate }}
     *     {{ title }} // will print the page title
     *     {{ _site_url }} // won't be available
     *   {{ /isolate }}
     *
     *   {{ isolate except="_site_url" }}
     *      {{ title }} // still prints the page title
     *      {{ _site_url }} // is now available
     *   {{ /isolate }}
     *
     * @return string
     */
    public function index()
    {
        $except = $this->fetchParam('except', null);
        $except = Helper::explodeOptions($except);
        $data   = Content::get($this->context['url'], true, false);

        foreach ($except as $var) {
            if (isset($this->context[$var])) {
                $data[$var] = $this->context[$var];
            }
        }

        return Parse::template($this->content, $data);
    }
}