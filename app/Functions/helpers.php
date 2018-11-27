<?php
use App\Menu;
if(!function_exists('dgg_menu')){
    function dgg_menu($name){
        $menus = optional(Menu::where('name', $name)->select(['id'])->first())->menuItem();
        $html = '';
        if($menus){
            foreach ($menus as $item){
                $withSub = (count($item->children) > 0) ? 'class="with-sub"' : '';
                $arrowSub = (count($item->children) > 0) ? '<span class="s-caret"><i class="fa fa-angle-down"></i></span>' : '';
                $iconClass = $item->icon_class ? '<span class="s-icon"><i class="'.$item->icon_class.'"></i></span>':'';
                $href = $item->route ? route($item->route) : $item->url;

                $html .= '<li '.$withSub.'>
                        <a href="'.$href.'" class="waves-effect waves-light">
                            '.$arrowSub.$iconClass.'
                            <span class="s-text">'.$item['title'].'</span>
                        </a>
                        '.childMenuItem($item->children).'	
                    </li>';

            }
        }
        return $html;
    }
    function childMenuItem($children){
        $childHtml = '';
        if(count($children) > 0){
            $childHtml .= '<ul>';
            foreach ($children as $child){
                $childWithSub = (count($child->children) > 0) ? 'class="with-sub"' : '';
                $childArrowSub = (count($child->children) > 0) ? '<span class="s-caret"><i class="fa fa-angle-down"></i></span>' : '';
                $childHref = $child->route ? route($child->route) : $child->url;
                $childHtml .= '<li '.$childWithSub.'>                                    
                                    <a href="'.$childHref.'" class="waves-effect waves-light">
                                        '.$childArrowSub.'
                                        <span class="s-text">'.$child->title.'</span>
                                    </a>
                                    '.childMenuItem($child->children).'
                               </li>';
            }
            $childHtml .='</ul>';
        }
        return $childHtml;
    }
}