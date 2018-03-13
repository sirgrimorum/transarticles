<?php

/**
 * Return the translation for the article
 * @param String $nickname The article to load using dot notation
 * @return String The content of the article localized, if not found, return the first article in a diferent language, if neither, returns de $nickname
 */
function trans_article($nickname) {
    return Sirgrimorum\TransArticles\GetArticleFromDataBase::get($nickname);
}
