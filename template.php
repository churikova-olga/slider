
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// $APPLICATION->AddHeadScript('/bitrix/templates/.default/components/bitrix/news.list/js/slider.js');
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="slideshow-container">

<div class="dot-container">
	<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
		<span class="dot" onclick="currentSlide(<?=$key+1?>)"></span>
	<?endforeach;?>	
</div>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>

<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>


	<div class="mySlides animation" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

          	<div class="circle-border">
            	<span class="circle-image">
					<!-- Вывод картинки -->
					<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
						
						<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
							<a href="<?=$arItem["PROPERTIES"]["Link"]["VALUE"] !== '' ?$arItem["PROPERTIES"]["Link"]["VALUE"] : $arItem["DETAIL_PAGE_URL"]?>"><img
									class="slide-img"
									border="0"
									src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
									width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
									height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
									alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
									title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
									style="float:left"
									/></a>
				
						<?endif;?>

					<?endif?>
				</span>
          	</div>
        <q><?=$arItem["PROPERTIES"]["Text"]["VALUE"]?></q>

        <p class="author"><?=$arItem["PROPERTIES"]["Author"]["VALUE"]?></p> 

		</div>
<?endforeach;?>
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
