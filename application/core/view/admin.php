<?php

class Admin_View extends View
{
	public function __construct($page)
	{
		parent::__construct($page);
	}

	public function ShowPage($data, $user)
	{
		$result = NULL;

		foreach ($data as $i => $j)
		{
			foreach ($j as $k => $v)
			{
				if ($k == 'group')
				{
					$group = $v;

					$result .= '<div class="AdminGroupName">';
					$result .= $group;
					$result .= '</div>';
				}
				if ($k == 'elements')
				{
					$result .= '<div class="AdminGroupElements">';
					$result .= '<table>';
					$result .= '<tr>';

					foreach ($v as $kk => $vv)
					{
						foreach ($vv as $key => $value)
						{
							if ($key == 'profile') $profile = $value;
							if ($key == 'caption') $caption = $value;
							if ($key == 'link') $link = $value;
							if ($key == 'icon') $icon = $value;
						}
						if ($user->get_value('user_status') <= $profile)
						{
							$result .= '<td class="AdminGroupElement">';
							$result .= '<a href="'.$link.'">';
							$result .= '<p>';
							$result .= '<img src="img/48x48/'.$icon.'" alt="" />';
							$result .= '</p>';
							$result .= '<p>';
							$result .= $caption;
							$result .= '</p>';
							$result .= '</a>';
							$result .= '</td>';
						}
						else // not allowed
						{
							$result .= '<td class="AdminGroupElement">';
							$result .= '<a href="'.$link.'" class="disabled">';
							$result .= '<p class="disabled">';
							$result .= '<img src="img/48x48/'.$icon.'" alt="" />';
							$result .= '</p>';
							$result .= '<p class="disabled">';
							$result .= $caption;
							$result .= '</p>';
							$result .= '</a>';
							$result .= '</td>';
						}
					}

					$result .= '</tr>';
					$result .= '</table>';
					$result .= '</div>';
				}
			}
		}

		return $result;
	}
}

?>
