<?php
require 'util.php';

/**
 * Regex in a nutshell: advanced 'find and/or replace' for strings.
 *
 * A typical regex pattern:
 * - is enclosed in delimiters (typically a pair of forward slashes)
 * - consists of a sequence of characters, meta-characters (like ., \d, \s, \S)
 * and operators (like +, *, ?, |, ^)
 *
 * PHP manual page for regular expressions: http://php.net/manual/en/ref.pcre.php
 *
 * Online tool for composing/debugging regex: https://regex101.com/#pcre
 *
 * Interactive exercises: https://regexone.com/
 *
 * (Most test strings in this file are H. P. Lovecraft references. I may or may not be sorry.)
 */


/*************************************************************************
 * preg_match() && preg_match_all() - find and optionally return matches *
 *************************************************************************/

/************************************************************
 * The most simple regex match: matching a string to itself *
 ************************************************************/
/**
 * @param string $string
 * @return bool
 */
function matchesItself($string)
{
    return preg_match("/{$string}/", $string) === 1;
}

$string = 'Cthulhu';
//writeBoolean(matchesItself($string));
//writeBoolean(strcmp($string, $string) === 0);


/**************************************************************************************
 * To match special characters with a specific meaning in regex, you must escape them *
 **************************************************************************************/
/**
 * @param string $string
 * @return bool
 */
function matchesItselfInquisitively($string)
{
    return preg_match("/{$string}\?/", $string) === 1;
}

//writeBoolean(matchesItselfInquisitively('Cthulhu?'));


/*****************************************************************************************
 * To match several alternatives, separate them with the OR operator, namely the pipe: | *
 *****************************************************************************************/
/**
 * @param string $string
 * @return bool
 */
function matchesMultipleWords($string)
{
    return preg_match('/hideous|shadowy|infernal/', $string) === 1;
}

//writeBoolean(matchesMultipleWords('hideous'));
//writeBoolean(matchesMultipleWords('infernal'));
//writeBoolean(matchesMultipleWords('glittery'));


/*******************************************************************************************
 * To specify a range or list of characters, use the bracket list notation, namely [ ... ] *
 *******************************************************************************************/

/**
 * @param string $string
 * @return false|int
 */
function matchesRangeOfAlphanumericCharacters($string)
{
    // matches a single character in the list [a-zA-Z0-9_]
    return preg_match('/[a-zA-Z0-9_]/', $string) === 1;
}

//writeBoolean(matchesRangeOfAlphaNumericCharacters('tentacle'));
//writeBoolean(matchesRangeOfAlphaNumericCharacters('0'));
//writeBoolean(matchesRangeOfAlphaNumericCharacters('-'));

/**
 * @param string string
 * @return bool
 */
function matchesAnythingButAlphanumericCharacters($string)
{
    // matches a single character NOT in the list [a-zA-Z0-9_] (note the ^, signifying the negation)
    return preg_match('/[^a-zA-Z0-9_]/', $string) === 1;
}

//writeBoolean(matchesAnythingButAlphaNumericCharacters('green'));
//writeBoolean(matchesAnythingButAlphaNumericCharacters('0'));
//writeBoolean(matchesAnythingButAlphaNumericCharacters('-'));

/**
 * @param string $string
 * @return bool
 */
function matchesWordVariants($string)
{
    // matches 'bat', 'bet', 'bit', 'bot', and 'but'
    return preg_match('/b[aeiou]t/', $string) === 1;
}

//writeBoolean(matchesWordVariants('bat'));
//writeBoolean(matchesWordVariants('bxt'));


/***************************************************************************
 * Simplify your life using meta-characters/meta sequences like ., \w, \D  *
 **************************************************************************/

/**
 * @param $string
 * @return bool
 */
function matchesAnyCharacterAndAWordCharacter($string)
{
    // note that \w is equivalent to [a-zA-Z0-9_]
    return preg_match('/.\w/', $string) === 1;
}

//writeBoolean(matchesAnyCharacterAndAWordCharacter('?'));
//writeBoolean(matchesAnyCharacterAndAWordCharacter('no'));
//writeBoolean(matchesAnyCharacterAndAWordCharacter('9 '));

/**
 * @param $string
 * @return bool
 */
function matchesAnyDigit($string)
{
    // note that \d is equivalent to [0-9]
    return preg_match('/\d/', $string) === 1;
}

//writeBoolean(matchesAnyDigit('9'));
//writeBoolean(matchesAnyDigit('delirium'));

/**
 * @param $string
 * @return bool
 */
function matchesTwoNonWhitespacesAndOneWhitespace($string)
{
    return preg_match('/\S\S\s/', $string) === 1;
}

//writeBoolean(matchesTwoNonWhitespacesAndOneWhitespace(' oh'));
//writeBoolean(matchesTwoNonWhitespacesAndOneWhitespace('oh '));
//writeBoolean(matchesTwoNonWhitespacesAndOneWhitespace(' '));
//writeBoolean(matchesTwoNonWhitespacesAndOneWhitespace('      '));


/*********************************************************************************************
 * Use occurrence indicators/quantifiers to specify the number of times a pattern must match *
 *********************************************************************************************/

/**
 * @param string $string
 * @return bool
 */
function matchesPluralOptionally($string)
{
    return preg_match("/{$string}s?/", $string) === 1;
}

//writeBoolean(matchesPluralOptionally('creature'));
//writeBoolean(matchesPluralOptionally('creatures'));

/**
 * @param string $string
 * @return bool
 */
function matchesWhitespaceZeroOrMoreTimes($string)
{
    return preg_match("/\s*/", $string) === 1;
}

//writeBoolean(matchesWhitespaceZeroOrMoreTimes('strange'));
//writeBoolean(matchesWhitespaceZeroOrMoreTimes(' chant '));

/**
 * @param string $string
 * @return bool
 */
function matchesDigitAtLeastOnce($string)
{
    return preg_match("/\d+/", $string) === 1;
}

//writeBoolean(matchesDigitAtLeastOnce('1'));
//writeBoolean(matchesDigitAtLeastOnce('nightmare'));

/**
 * Note that this function returns the matches for the pattern!
 *
 * @param string $string
 * @return array
 */
function extractMatchesForQuoteNonGreedily($string)
{
    // to make multipliers non-greedy, add a '?' to them
    preg_match('/".*?"/', $string, $matches);

    return $matches;
}

//writeArray(extractMatchesForQuoteNonGreedily('"In his house at R’lyeh dead Cthulhu waits dreaming," he said. "You know?"'));

/**
 * @param string $string
 * @return bool
 */
function matchesThreeWordCharacters($string)
{
    return preg_match('/\w{3}/', $string) === 1;
}

//writeBoolean(matchesThreeWordCharacters('no'));
//writeBoolean(matchesThreeWordCharacters('red'));
//writeBoolean(matchesThreeWordCharacters('glare')); // for words strictly three chars long, you'll need a word boundary (stay tuned)

/**
 * @param string $string
 * @return bool
 */
function matchesBetweenThreeAndFiveDigits($string)
{
    return preg_match('/\d{3,5}/', $string) === 1;
}

//writeBoolean(matchesBetweenThreeAndFiveDigits('12'));
//writeBoolean(matchesBetweenThreeAndFiveDigits('123'));
//writeBoolean(matchesBetweenThreeAndFiveDigits('p037ry'));

/**
 * @param string $string
 * @return bool
 */
function matchesVariantSpellingOfColour($string)
{
    return preg_match('/colou{0,1}r/', $string) === 1;
}

//writeBoolean(matchesVariantSpellingOfColour('color'));
//writeBoolean(matchesVariantSpellingOfColour('colour'));


/***************************************************
 * Use modifiers to control the matching behaviour *
 ***************************************************/

/**
 * @param string $string
 * @return bool
 */
function matchesWordCaseInsensitive($string)
{
    return preg_match("/word/i", $string) === 1;
}

//writeBoolean(matchesWordCaseInsensitive('word'));
//writeBoolean(matchesWordCaseInsensitive('WORD'));

/**
 * @param string $string
 * @return array
 */
function extractAllLetters($string)
{
    // normally, what you do to extract all matches is use the /g flag
    // in PHP, the function to use is preg_match_all()
    preg_match_all('/[a-zA-Z]+/', $string, $matches);
    return $matches;
}

//writeArray(extractAllLetters('5dreams 1hidden and876 123untouched'));


/************************************************************************************
 * Use positional meta-characters/anchors to match characters at specific positions *
 ************************************************************************************/

/**
 * @param string $string
 * @return bool
 */
function matchesDashAtBeginningAndEnd($string)
{
    return preg_match('/^-\w*-$/', $string) === 1;
}

//writeBoolean(matchesDashAtBeginningAndEnd('-cryptic-'));
//writeBoolean(matchesDashAtBeginningAndEnd('cryptic-'));
//writeBoolean(matchesDashAtBeginningAndEnd('cryptic'));

/**
 * @param string $string
 * @return array
 */
function extractAllFiveLetterWords($string)
{
    // the \b (or word boundary): "whole words only" search
    preg_match_all('/\b\w{5}\b/', $string, $matches);

    return $matches;
}

//writeArray(extractAllFiveLetterWords('sticky spawn of the stars'));


/******************************************************************
 * Recover your matches with capturing (and non-capturing) groups *
 ******************************************************************/

/**
 * @param string $string
 * @return array
 */
function extractImageFileName($string)
{
    preg_match('/^(\w+)\.(?:(?:png)|(?:jpg))$/', $string, $matches);

    return $matches;
}

//writeArray(extractImageFileName('yig_at_the_beach.jpg'));
//writeArray(extractImageFileName('azazel_wedding_prank.jpg.fake'));

/**
 * @param string $string
 * @return array
 */
function extractImageFileNameWithNamedPattern($string)
{
    preg_match('/^(?<image_name>\w+)\.(?:(?:png)|(?:jpg))$/', $string, $matches);

    return $matches;
}

//writeArray(extractImageFileNameWithNamedPattern('yuggoth_seascape.png'));

/**
 * @param array $words
 * @param string $text
 * @return array
 */
function extractLinesThatMatchWords(array $words, $text)
{
    $alternatives = implode('|', $words);

    $pattern = "/^.*\b({$alternatives})\b.*$/m";

    preg_match_all($pattern, $text, $matches);

    return $matches;
}

$text = 'Asenath, it seemed, had posed as a kind of magician at school; and had really seemed able to accomplish some highly baffling marvels. 
She professed to be able to raise thunderstorms, though her seeming success was generally laid to some uncanny knack at prediction.
All animals markedly disliked her, and she could make any dog howl by certain motions of her right hand.';
//writeArray(extractLinesThatMatchWords(array('marvels', 'motions'), $text));

/**
 * @param array $words
 * @param string $text
 * @param int $distance
 * @return bool
 */
function matchesWordsCloseToEachOther(array $words, $text, $distance)
{
    // compose pattern
    // the end result for words 'foo' and 'bar' should look something like \b(?:foo\W+(?:\w+\W+){0,5}?bar)\b
    // ... or maybe you have a better pattern :)
    $wordCount = count($words);
    $pattern = '/\b(?:';

    foreach ($words as $i => $word) {
        if ($i != ($wordCount - 1)) {
            $pattern .= "{$word}\W+(?:\w+\W+){0,{$distance}}?";
            continue;
        }

        $pattern .= $word;
    }

    $pattern .= ')\b/';

    return preg_match($pattern, $text) === 1;
}

$text = 'all traces of such things are wholly overshadowed by a potent and inborn sense of the spectral, the morbid, and the horrible';
//writeBoolean(matchesWordsCloseToEachOther(array('potent', 'spectral', 'horrible'), $text, 5));


/****************************
 * Lookahead and lookbehind *
 ****************************/

/**
 * @param string $string
 * @return bool
 */
function matchesWordsPrefixedWithMidExceptMidnight($string)
{
    // negative lookahead
    return preg_match('/mid(?!night)/', $string) === 1;
}

//writeBoolean(matchesWordsPrefixedWithMidExceptMidnight('midnight'));
//writeBoolean(matchesWordsPrefixedWithMidExceptMidnight('midday'));

/**
 * @param string $string
 * @return bool
 */
function matchesWordsPrefixedWithConThatAreConcealedOrContorted($string)
{
    // positive lookahead
    return preg_match('/con(?=cealed|torted)/', $string) === 1;
}

//writeBoolean(matchesWordsPrefixedWithConThatAreConcealedOrContorted('concealed'));
//writeBoolean(matchesWordsPrefixedWithConThatAreConcealedOrContorted('contorted'));
//writeBoolean(matchesWordsPrefixedWithConThatAreConcealedOrContorted('contribute'));

/**
 * @param string $string
 * @return bool
 */
function matchesDeadExceptWhenNotDead($string)
{
    // negative lookbehind
    return preg_match('/(?<!not )dead/', $string) === 1;
}

//writeBoolean(matchesDeadExceptWhenNotDead('not dead'));
//writeBoolean(matchesDeadExceptWhenNotDead('not dead but dead'));
//writeBoolean(matchesDeadExceptWhenNotDead('dead'));

/**
 * @param string $string
 * @return bool
 */
function matchesDystopiaOrUtopia($string)
{
    // positive lookbehind
    return preg_match('/(?<=dys|u)topia/', $string) === 1;
}

//writeBoolean(matchesDystopiaOrUtopia('dystopia'));
//writeBoolean(matchesDystopiaOrUtopia('utopia'));
//writeBoolean(matchesDystopiaOrUtopia('zootopia'));


/***************************************************************************************************
 * Be careful with symbols and non-English languages!                                              *
 *                                                                                                 *
 * PHP preg_ functions support Unicode when the /u modifier is appended to the regular expression. *
 * You can also use Unicode categories-specific notation.                                          *
 *                                                                                                 *
 * Check out https://www.regular-expressions.info/unicode.html                                     *
 ***************************************************************************************************/

/**
 * @param string $string
 * @return bool
 */
function matchesWithUnicodeSupport($string)
{
    return preg_match('/\w/u', $string) === 1;
}

//writeBoolean(matchesWithUnicodeSupport('Þ'));

/**
 * @param string $string
 * @return bool
 */
function matchesAnyLetterInAnyLanguage($string)
{
    return preg_match('/\p{L}/', $string) === 1;
}

//writeBoolean(matchesAnyLetterInAnyLanguage('Iä!'));

/**
 * @param string $character
 * @return bool
 */
function matchesMathematicalSymbol($character)
{
    return preg_match('/\p{Sm}*/u', $character) === 1;
}

//writeBoolean(matchesMathematicalSymbol('≈'));


// Regular expressions are very useful, but also very time-consuming. For this reason, limiting their use is highly recommended.
// E.g.: use str_replace() instead of preg_replace() where possible.

/***************
 * preg_grep() *
 ***************/

//writeArray(preg_grep('/(css|js)/', ['portal.css', 'mortals.js', 'temple.php']));
//writeArray(preg_grep('/(jpg|png)/', ['portal.css', 'mortals.js', 'temple.php'], PREG_GREP_INVERT));


/***********************************
 * preg_filter() && preg_replace() *
 ***********************************/

//writeArray(preg_filter('/less/', 'ed', ['limitless', 'darkness', 'space']));

//writeArray(preg_replace('/less/', 'ed', ['limitless', 'darkness', 'space']));
//writeArray(str_replace('less', 'ed', ['limitless', 'darkness', 'space']));


/*****************
 * preg_split() *
 ****************/

$htmlString = "<p>paragraph</p><span>span</span><ol><li>list1</li><li>list2</li></ol>";
//writeArray(preg_split('/<\/?[a-z]+>/', $htmlString, null, PREG_SPLIT_NO_EMPTY));

$string = 'the oldest and strongest kind of fear is fear of the unknown';
//writeArray(str_split($string));
//writeArray(explode(' ', $string));


/**********************************************
 * preg_replace() && preg_replace_callback() *
 **********************************************/

//writeString(preg_replace('/cat/', '???',  'catastrophic category of cataclysms'));

//writeString(preg_replace_callback(
//    '/(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2})/',
//    function ($matches) {
//        return $matches['day'] . '.' . $matches['month'] . '.' . $matches['year'];
//    },
//    '2000-01-11'
//));


/***********************************************
 * It's all fun and games ...                  *
 * Think of ways to improve the regexes below! *
 ************************************************/

/**
 * @param string $string
 * @return array
 */
function extractEmails($string)
{
    preg_match_all('/\w+@\w+\.\w{2,3}/', $string, $matches);

    return $matches;
}

//writeArray(extractEmails('These are my emails: old_one@abyss.com, nightmother@spacetime.org'));

/**
 * @param $string
 * @return array
 */
function extractURL($string)
{
    preg_match('/(?:http)\:\/\/[a-zA-Z0-9\-]+\.[a-zA-Z]{2,3}/', $string, $matches);

    return $matches;
}

//writeArray(extractURL('The URL is http://regex101.com/#pcre'));

/**
 * @param $string
 * @return array
 */
function extractFullName($string)
{
    preg_match('/[A-Z][a-z]+ [A-Z][a-z]+/', $string, $matches);

    return $matches;
}

//writeArray(extractFullName('Please meet Randolph Carter.'));
