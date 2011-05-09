<?php

/**
 * Add smart context code to the response.
 *
 * @package     sfSmartContextPlugin
 * @subpackage  filter
 * @author      Tomasz Jakub Rup <tomasz.rup@gmail.com>
 */
class sfSmartContextFilter extends sfFilter
{
  /**
   * Insert smart context code for applicable web requests.
   *
   * @param   sfFilterChain $filterChain
   */
  public function execute($filterChain)
  {
    $request  = $this->context->getRequest();
    $response = $this->context->getResponse();

    $filterChain->execute();

    if (sfConfig::get('app_smart_context_plugin_enabled', false) !== true || !$this->isTrackable()) return;

	$site = sfConfig::get('app_smart_context_plugin_site', '');

    $html = array();
    $html[] = '<script type="text/javascript">';
    $html[] = '//<![CDATA[';
    $html[] = "var bbSite='{$site}';";
    $html[] = 'var bbMainDomain=\'new.smartcontext.pl\';';
    $html[] = '//]]>';
    $html[] = '</script>';
    $html[] = "<script type=\"text/javascript\" src=\"http://code.new.smartcontext.pl/code/{$site}/code.js\"></script>";

    $html = join("\n", $html);

    $old = $response->getContent();
    $new = str_ireplace('</body>', "\n".$html."\n</body>", $old);
    if ($old == $new)
    {
      $new .= $html;
    }

    $response->setContent($new);
  }

  /**
   * Test whether the response is trackable.
   * 
   * @return  bool
   */
  protected function isTrackable()
  {
    $request    = $this->context->getRequest();
    $response   = $this->context->getResponse();
    $controller = $this->context->getController();
    
    // don't add analytics:
    // * for XHR requests
    // * if not HTML
    // * if 304
    // * if not rendering to the client
    // * if HTTP headers only
    if ($request->isXmlHttpRequest() ||
        strpos($response->getContentType(), 'html') === false ||
        $response->getStatusCode() == 304 ||
        $controller->getRenderMode() != sfView::RENDER_CLIENT ||
        $response->isHeaderOnly())
    {
      return false;
    }
    else
    {
      return true;
    }
  }

}
