
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult["ERROR_MESSAGE"])): 
?>
<div class="vote-note-box vote-note-error">

	<div class="vote-note-box-text"><?=ShowError($arResult["ERROR_MESSAGE"])?></div>
</div>
<?
endif;

if (!empty($arResult["OK_MESSAGE"])): 
?>
<div class="vote-note-box vote-note-note">
	<div class="vote-note-box-text"><?=ShowNote($arResult["OK_MESSAGE"])?></div>
</div>
<?
endif;

if (empty($arResult["VOTE"])):
	return false;
elseif (empty($arResult["QUESTIONS"])):
	return true;
endif;

?>
<div class="voting-form-box">
<form action="<?=POST_FORM_ACTION_URI?>" method="post" class="vote-form">

	<input type="hidden" name="vote" value="Y">
	<input type="hidden" name="PUBLIC_VOTE_ID" value="<?=$arResult["VOTE"]["ID"]?>">
	<input type="hidden" name="VOTE_ID" value="<?=$arResult["VOTE"]["ID"]?>">
	<?=bitrix_sessid_post()?>

<a class="start-quize" onclick="startSlide(1)">Пройти опрос</a>
<div class="slideshow-container">
<div class="dot-container">
	<?foreach ($arResult["QUESTIONS"] as $key=>$arQuestion):?>
        <span class="dot" onclick="currentSlide(<?=$key?>)"></span>
	<?endforeach?>
</div>
<ol class="vote-items-list vote-question-list">
<?
	$iCount = 0;
	foreach ($arResult["QUESTIONS"] as $arQuestion):
		$iCount++;

?>
	<!-- <div class="mySlides animation">  -->

	<li style="padding: 0 20px;" class="mySlides animation vote-item-vote <?=($iCount == 1 ? "vote-item-vote-first " : "")?><?
				?><?=($iCount == count($arResult["QUESTIONS"]) ? "vote-item-vote-last " : "")?><?
				?><?=($iCount%2 == 1 ? "vote-item-vote-odd " : "vote-item-vote-even ")?><?
				?>">

	<div class="vote-item-header">

<?
		if ($arQuestion["IMAGE"] !== false):
?>
			<div class="vote-item-image"><img src="<?=$arQuestion["IMAGE"]["SRC"]?>" width="30" height="30" /></div>
<?
		endif;
?>
	<div class="vote-item-title vote-item-question"><?=$arQuestion["QUESTION"]?><?if($arQuestion["REQUIRED"]=="Y"){echo "<span class='starrequired'>*</span>";}?></div>
			<div class="vote-clear-float"></div>
	</div>
		



		<ol class="vote-items-list vote-answers-list">
<?
		$iCountAnswers = 0;
		foreach ($arQuestion["ANSWERS"] as $arAnswer):
			$iCountAnswers++;
?>
			<li class="vote-item-vote <?=($iCountAnswers == 1 ? "vote-item-vote-first " : "")?><?
						?><?=($iCountAnswers == count($arQuestion["ANSWERS"]) ? "vote-item-vote-last " : "")?><?
						?><?=($iCountAnswers%2 == 1 ? "vote-item-vote-odd " : "vote-item-vote-even ")?>">
<?
			switch ($arAnswer["FIELD_TYPE"]):
					case 0://radio
						$value=(isset($_REQUEST['vote_radio_'.$arAnswer["QUESTION_ID"]]) && 
							$_REQUEST['vote_radio_'.$arAnswer["QUESTION_ID"]] == $arAnswer["ID"]) ? 'checked="checked"' : '';
					break;
					case 1://checkbox
						$value=(isset($_REQUEST['vote_checkbox_'.$arAnswer["QUESTION_ID"]]) && 
							array_search($arAnswer["ID"],$_REQUEST['vote_checkbox_'.$arAnswer["QUESTION_ID"]])!==false) ? 'checked="checked"' : '';
					break;
					case 2://select
						$value=(isset($_REQUEST['vote_dropdown_'.$arAnswer["QUESTION_ID"]])) ? $_REQUEST['vote_dropdown_'.$arAnswer["QUESTION_ID"]] : false;
					break;
					case 3://multiselect
						$value=(isset($_REQUEST['vote_multiselect_'.$arAnswer["QUESTION_ID"]])) ? $_REQUEST['vote_multiselect_'.$arAnswer["QUESTION_ID"]] : array();
					break;
					case 4://text field
						$value = isset($_REQUEST['vote_field_'.$arAnswer["ID"]]) ? htmlspecialcharsbx($_REQUEST['vote_field_'.$arAnswer["ID"]]) : '';
					break;
					case 5://memo
						$value = isset($_REQUEST['vote_memo_'.$arAnswer["ID"]]) ?  htmlspecialcharsbx($_REQUEST['vote_memo_'.$arAnswer["ID"]]) : '';
					break;
				endswitch;
?>
<?
			switch ($arAnswer["FIELD_TYPE"]):
					case 0://radio
?>
						<span class="vote-answer-item vote-answer-item-radio">
						
						<input type="radio" <?=$value?> name="vote_radio_<?=$arAnswer["QUESTION_ID"]?>" <?
								?>id="vote_radio_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>" <?
								?>value="<?=$arAnswer["ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?>/>
							<label for="vote_radio_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label>
							
						</span>
<?
					break;
					case 1://checkbox?>
						<span class="vote-answer-item vote-answer-item-checkbox">
							<input <?=$value?> type="checkbox" name="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>[]" value="<?=$arAnswer["ID"]?>" <?
								?> id="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?> />
							<label for="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label>
						</span>
					<?break?>

					<?case 2://dropdown?>
						<span class="vote-answer-item vote-answer-item-dropdown">
							<select name="vote_dropdown_<?=$arAnswer["QUESTION_ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?>>
								<option value=""><?=GetMessage("VOTE_DROPDOWN_SET")?></option>
							<?foreach ($arAnswer["DROPDOWN"] as $arDropDown):?>
								<option value="<?=$arDropDown["ID"]?>" <?=($arDropDown["ID"] === $value)?'selected="selected"':''?>><?=$arDropDown["MESSAGE"]?></option>
							<?endforeach?>
							</select>
						</span>
					<?break?>

					<?case 3://multiselect?>
						<span class="vote-answer-item vote-answer-item-multiselect">
							<select name="vote_multiselect_<?=$arAnswer["QUESTION_ID"]?>[]" <?=$arAnswer["~FIELD_PARAM"]?> multiple="multiple">
							<?foreach ($arAnswer["MULTISELECT"] as $arMultiSelect):?>
								<option value="<?=$arMultiSelect["ID"]?>" <?=(array_search($arMultiSelect["ID"], $value)!==false)?'selected="selected"':''?>><?=$arMultiSelect["MESSAGE"]?></option>
							<?endforeach?>
							</select>
						</span>
					<?break?>

					<?case 4://text field?>
						<span class="vote-answer-item vote-answer-item-textfield">
							<label for="vote_field_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label>
							<input type="text" name="vote_field_<?=$arAnswer["ID"]?>" id="vote_field_<?=$arAnswer["ID"]?>" <?
								?>value="<?=$value?>" size="<?=$arAnswer["FIELD_WIDTH"]?>" <?=$arAnswer["~FIELD_PARAM"]?> /></span>
					<?break?>

					<?case 5://memo?>
						<span class="vote-answer-item vote-answer-item-memo">
							<label for="vote_memo_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label><br />
							<textarea name="vote_memo_<?=$arAnswer["ID"]?>" id="vote_memo_<?=$arAnswer["ID"]?>" <?
								?><?=$arAnswer["~FIELD_PARAM"]?> cols="<?=$arAnswer["FIELD_WIDTH"]?>" <?
							?>rows="<?=$arAnswer["FIELD_HEIGHT"]?>"><?=$value?></textarea>
						</span>
					<?break;
				endswitch;
?>
			</li>
<?
			endforeach
?>
		</ol>

	</li>

	<!-- </div> -->
<?
		endforeach
?>
	<div class="container-buttons">
		<a class="prev" onclick="plusSlides(-1)">Назад</a>
		<a class="next" onclick="plusSlides(1)">Далее</a>
	
	</div>
	<div class="vote-form-box-buttons vote-vote-footer">
	<span class="vote-form-box-button vote-form-box-button-first">
		<input class="vote-form-submit" type="submit" name="vote" value="<?=GetMessage("VOTE_SUBMIT_BUTTON")?>" />
	</span>
<?/*?>	<span class="vote-form-box-button vote-form-box-button-last"><input type="reset" value="<?=GetMessage("VOTE_RESET")?>" /></span><?*/?>

</div>
</ol>

</div>


</form>
</div>
<script>
let index = 1;
showSlides(index);

function plusSlides(n) {
  	showSlides((index += n));
}
function currentSlide(n){
	showSlides((index = n));
}
function startSlide(n) {
	document.querySelector(".vote-vote-footer").style.display = "none";
	document.querySelector(".start-quize").style.display = "none";
	document.querySelector(".slideshow-container").style.display = "block";
  	showSlides((index = n));
 
}

function showSlides(n) {
  	let i;
  	let slides = document.getElementsByClassName("mySlides");
  	let dots = document.getElementsByClassName("dot");

	let prev = document.querySelector(".prev")
	let next = document.querySelector(".next")
	let ans =  document.querySelector(".vote-vote-footer")

  	if (n === slides.length) {
    	next.style.display = "none"
		ans.style.display = "flex"
		prev.style.display = "block"
  	}
	else if (n === 1) {
		prev.style.display = "none"
		next.style.display = "block"
	}
	else{
		next.style.display = "block"
		prev.style.display = "block"
		ans.style.display = "none"
	}
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";
	}
	for (i = 0; i < dots.length; i++) {
		dots[i].classList.remove("active");
	}
  	slides[index - 1].style.display = "flex";
  dots[index - 1].classList.add("active");
}

</script>