<?php

class CORE_View_Helper_MenuSupr {

    public function menu($navigation, $cssClass = null, $type = 'normal') {
        if ($type == 'navlist') {
            return $this->_navList($navigation, $cssClass);
        }

        return $this->_normal($navigation, $cssClass);
    }

    protected function _normal($navigation, $cssClass = null) {
        $html = array('<ul>');

        foreach ($navigation->getContainer() as $page) {
            // visibility of the page
            if (!$page->isVisible()) {
                continue;
            }

            // dropdown
            $dropdown = !empty($page->pages);

            $liClass = array();

            if ($page->isActive()) {
                $liClass[] = 'active';
            }

            if ($dropdown) {
                $liClass[] = 'dropdown';
            }

            $htmlSubpaginas = array('<ul class="sub">');

            $countInativas = 0;
            $algumAtivo = false;
            foreach ($page->pages as $subpage) {
                if ($subpage->isActive()) {
                    $algumAtivo = true;
                }

                // visibility of the sub-page
                if (!$subpage->isVisible()) {
                    $countInativas++;
                    continue;
                }

//                if (!Zend_Registry::get('acl')->isAllowed(Zend_Registry::get('role'), $subpage->getResource(), $subpage->getPrivilege())) {
//                    $countInativas++;
//                    continue;
//                }

                $htmlSubpaginas[] = '<li' . ($subpage->isActive() ? ' class="active"' : '') . '>';
                $htmlSubpaginas[] = '<a href="' . $subpage->getHref() . '">';

                if ($subpage->get('icon')) {
                    $htmlSubpaginas[] = '<i class="icon-' . $subpage->get('icon') . '"></i>';
                }

                $htmlSubpaginas[] = $subpage->getLabel();
                $htmlSubpaginas[] = "</a>";
                $htmlSubpaginas[] = "</li>";
            }

            $htmlSubpaginas[] = "</ul>";

//            if (!Zend_Registry::get('acl')->isAllowed(Zend_Registry::get('role'), $page->getResource(), $page->getPrivilege())) {
//                $countInativas++;
//                continue;
//            }

            if (count($page->pages) == $countInativas) {
                $dropdown = false;
                $htmlSubpaginas = array();
            }

            if ($algumAtivo) {
                $liClass[] = 'active';
            }

            // header
            $html[] = '<li' . (( count($liClass) > 0 ) ? ' class="' . implode(' ', $liClass) . '"' : '') . '>';
            $htmlPagina = array('<a href="' . ($dropdown ? '#' : $page->getHref()) . '" '
                . ($dropdown ? 'class="dropdown-toggle" data-toggle="dropdown"' : null)
                . '>');
            $htmlPagina[] = $page->getLabel();

            if ($dropdown) {
                $htmlPagina[] = '<b class="caret"></b>';
            }

            $htmlPagina[] = '</a>';

            $html = array_merge($html, $htmlPagina);
            $html = array_merge($html, $htmlSubpaginas);

            $html[] = "</li>";
        }

        $html[] = '</ul>';

        return join(PHP_EOL, $html);
    }

}