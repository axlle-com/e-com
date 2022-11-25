<?php

namespace App\Common\Assets;

/**
 * Main frontend application asset.
 */
class MainAsset extends Asset
{
    public function head()
    {
        return view('inc.head', $this->toArray());
    }
}
