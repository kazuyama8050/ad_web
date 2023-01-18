<?php
namespace App\Validation;
use App\Models\Template\Template;
use \Symfony\Component\HttpFoundation\Response;
class TemplateValidation
{
    private $mimeList = [
        'png',
        'jpg',
    ];

    public function validateBannerText($text) {
        if (mb_strlen($text) > Template::MAX_TEXT_SIZE || mb_strlen($text) < Template::MIN_TEXT_SIZE) {
            abort(response()->json(['message' => 'バナーテキストは10文字以上50文字以内で入力してください。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateurl($url) {
        if (!preg_match(Template::URL_PATTERN, $url)) {
            abort(response()->json(['message' => '不正な遷移先URLの形式です。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateBannerImageSize($image) {
        $imageWidth = getimagesize($image)[0];
        $imageHeight = getimagesize($image)[1];

        if ($imageWidth != Template::IMAGE_WIDTH || $imageHeight != Template::IMAGE_HEIGHT) {
            abort(response()->json(['message' => 'バナー画像のサイズは30×30で指定してください。'], Response::HTTP_BAD_REQUEST));
        }
        return true;
    }

    public function validateBannerImageMime($image) {
        $imageMime = $image->extension();
        if (!in_array($imageMime, $this->mimeList)) {
            abort(response()->json(['message' => 'バナー画像はpng、jpgのみアップロード可能です。'], Response::HTTP_BAD_REQUEST));
        }
        return true;
    }

}