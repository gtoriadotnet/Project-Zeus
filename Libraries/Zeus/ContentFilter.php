<?php

namespace Zeus
{
	class ContentFilter
	{
		public static function FilterMessage($message, $strict)
		{
			$filterResult = $message;
			foreach(explode("\r\n", file_get_contents(__DIR__ . '/ContentFilter_blacklist.txt')) as $word)
			{
				$filterArray = [];
				preg_match_all($word, $filterResult, $filterArray, PREG_OFFSET_CAPTURE);
				foreach($filterArray[0] as $filterResultArray)
				{
					$filterLength = strlen($filterResultArray[0]);
					$filterResult = substr_replace($filterResult, str_repeat('#', $filterLength), $filterResultArray[1], $filterLength);
				}
			}
			return $filterResult;
		}
	}
}