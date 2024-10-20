/**
 * SyntaxHighlighter
 * http://alexgorbatchev.com/SyntaxHighlighter
 *
 * SyntaxHighlighter is donationware. If you are using it, please donate.
 * http://alexgorbatchev.com/SyntaxHighlighter/donate.html
 *
 * @version
 * 1.6.0 (Sun, 5 Aug 2018)
 *
 * @copyright
 * TypeScript brush Copyright (C) 2014-2018 Knarf A. Lingus.
 *
 * @license
 * Dual licensed under the MIT and GPL licenses.
 */
 
SyntaxHighlighter.brushes.TypeScript = function()
{
		// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Lexical_grammar
		var keywords =	'break case catch class const continue debugger default delete do else '
			+ 'export extends finally for function if import in instanceof new '
			+ 'return super switch this throw try typeof var void while with yield '
			// future reserved
			+ 'enum '
			// future reserved strict mode
			+ 'implements interface let package private protected public static '
			// literals
			+ 'false null true '
			// JS future reserved
			+ 'abstract boolean byte char double final float goto int long native short synchronized throws transient volatile '
			// Typescript 3.0
			+ 'any as async await Array constructor declare from get global infer is keyof module namespace never number object of require set static string symbol type undefined unique unknown ';
			
			 
		var chars 	

		var r = SyntaxHighlighter.regexLib;
		
		this.regexList = [
			{ regex: /&gt;/,										css: 'color1' },			// apparently need this to prevent &gt; replace??
																								// I think my highlighting of > triggers this somehow
			{ regex: /&amp;/,										css: 'color1' },			// ditto
			{ regex: /&lt;/,										css: 'color1' },			// ditto
			{ regex: /\s*\/\/#(region|endregion).*/gm,				css: 'script' },			// preprocessor tags like #region and #endregion (Web Essentials)
			{ regex: r.multiLineDoubleQuotedString,					css: 'string' },			// double quoted strings
			{ regex: r.multiLineSingleQuotedString,					css: 'string' },			// single quoted strings
			{ regex: r.singleLineCComments,							css: 'comments' },			// one line comments
			{ regex: r.multiLineCComments,							css: 'comments' },			// multi-line comments
			{ regex: /\s*@[a-zA-Z_$][a-zA-Z_$0-9]*/gm,				css: 'color3' },			// TypeScript 1.5, ES7 decorators
			{ regex: /(;|\(|\)|\[|\]|\.|{|})/gm,					css: 'color1' },			// highlight square & squiggly brackets, parentheses, dots and parentheses
			{ regex: /(%|\/|\+|\-|\*|=|,|:|\||&|\!|\<|\>|~|\^)/gm,	css: 'color1' },			// highlight operators&separators etc
			{ regex: new RegExp(this.getKeywords(keywords), 'gm'),	css: 'keyword' }			// keywords
			];
	
};
 
SyntaxHighlighter.brushes.TypeScript.prototype = new SyntaxHighlighter.Highlighter();
SyntaxHighlighter.brushes.TypeScript.aliases	= ['ts', 'tscript', 'typescript'];

