# "Structuration et programmation d'une base de données linguistiques"
>This project is presented as my "Master 1 MIASHS DCISS" intership project. The project took place at Gipsa-Lab, DPC deparment, from 6 May to the 22 May and was lead by Vallée Nathalie.  It is the result of 75 hours of work. 

![ScreenShot](readmeImages/articlePage1.png "Show article page")
![CommentPage](readmeImages/articlesPage2.png "Show comments page")

## Table of Contents

* [About the Project](#about-the-project)
  * [Objective](#objective)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
* [Usage](#usage)
    * [About the phoneme code](#About-the-code)
    * [Running the tests](#Running-the-tests)
* [Author](#Author)
* [Acknowledgements](#acknowledgements)

## About the Project 
This project contains : 
1. ProtoDB.db file: includes lexicons from 3 languages
2. protoClass.php: class squeleton  
3. create.php: to uploade new dato to ProtoDB.db
4. search.php: to do basic searchs inside the bd 
5. advSearch.php: to do an advance search 
6. public/uploads: lexicons files uploaded to the db 
7. public/templates: header & footer template
8. test4.php: contains diferent test   

### Objective 

The aim of the internship was to propose the structuring and the exploitation of a set of reconstructed lexical forms (ancient forms) organized for several languages ​​in the form of lexicons.

### Built With
* [php]- PHP 7.1.19
* [mysql]
* [css]
* [html]

## Getting Started

### Prerequisites

Verify your computer have php  
```
php --version
```
-Download Zip and unzipped it. 


### About the phoneme code 
Due to a combinaision of problems regarding the coding we decide it was going to be best if we change the phonemes non represented by a QWERTY keyboard inside de DB to be represented by a code legible by a browser. 

Here is a table with their codes: 
|id|phoneme|place|mode|voisement|consonnant|nasal|diacritic|
|---|---|---|---|---|---|---|---|
|1|	m|	Bi|	Na|	1|	1|	2|	0| |
|2|	&#625|	Lde|	Na|	1|	1|	2|	0|
|3|	n|	Al|	Na|	1|	1|	2|	0| |
|4|	&#627|	Re|	Na|	1|	1|	2|	0|
|5|	&#626|	Pa|	Na|	1|	1|	2|	0|
|6|	&#331|	Ve|	Na|	1|	1|	2|	0|
|7|	&#628|	Uv|	Na|	1|	1|	2|	0|
|8|	p|	Bi|	Pl|	0|	1|	|	0| |
|9|	b|	Bi|	Pl|	1|	1|	|	0| |
|10|	t|	Al|	Pl|	0|	1|	|	0|
|11|	d|	Al|	Pl|	1|	1|	|	0|
|12|	&#648|	Re|	Pl|	0|	1|	|	0|
|13|	&#598|	Re|	Pl|	1|	1|	|	0|
|14|	c|	Pa|	Pl|	0|	1|	|	0| |
|15|	&#607|	Pa|	Pl|	1|	1|	|	0|
|16|	k|	Ve|	Pl|	0|	1|	|	0| |
|17|	g|	Ve|	Pl|	1|	1|	|	0| |
|18|	q|	Uv|	Pl|	0|	1|	|	0| |
|19|	G|	Uv|	Pl|	1|	1|	|	0| |
|20|	&#673|	Ph|	Pl|	0|	1|	|	0|
|21|	&#660|	Gl|	Pl|	0|	1|	|	0|
|22|	s|	Al|	Fr|	0|	1|	|	0| |
|23|	z|	Al|	Fr|	1|	1|	|	0| |
|24|	&#643|	Poa|	Fr|	0|	1|		0|
|25|	&#658|	Poa|Fr|	1|	1|	|	0|
|26|	&#642|	Re|	Fr|	0|	1|	|	0|
|27|	&#656|	Re|	Fr|	1|	1|	|	0|
|28|	&#597|	Pa|	Fr|	0|	1|	|	0|
|29|	&#657|	Pa|	Fr|	1|	1|	|	0|
|30|	&#632|	Bi|	Fr|	0|	1|	|	0|
|31|	&#946|	Bi|	Fr|	1|	1|	|	0|
|32|	f|	Lde|	Fr|	0|	1|	|	0|
|33|	v|	Lde|Fr|	1|	1|	|	0| |
|34|	&#952|	De|	Fr|	0|	1|	|	0|
|35|	&#240|	De|	Fr|	1|	1|	|	0|
|36|	x|	Ve|	Fr|	0|	1|	|	0| |
|37|	&#611|	Ve|	Fr|	1|	1|	|	0|
|38|	X|	Uv|	Fr|	0|	1|	|	0|
|39|	&#641|	Uv|	Fr|	1|	1|	|	0|
|40|	&#295|	Ph|	Fr|	0|	1|	|	0|
|41|	&#661|	Ph|	Fr|	1|	1|	|	0|
|42|	h|	Gl|	Fr|	0|	1|	|	0| |
|43|	&#240|	Gl|	Fr|	1|	1|	|	0|
|44|	&#651|	Lde|	Ap|	1|	1|		0|
|45|	&#633|	Al|	Ap|	1|	1|	|	0|
|46|	&#635|	Re|	Ap|	1|	1|	|	0|
|47|	j|	Pa|	Ap|	1|	1|	|	0| |
|48|	&#624|	Ve|	Ap|	1|	1|	|	0|
|49|	&#11377|	Lde| Ta|	1|	1|		0|
|50|	&#638|	Al|	Ta|	1|	1|	|	0|
|51|	&#637|	Re|	Ta|	1|	1|	|	0|
|52|	B|	Bi|	Tr|	1|	1|	|	0| |
|53|	r|	Al|	Tr|	1|	1|	|	0| |
|54|	R|	Uv|	Tr|	1|	1|	|	0| |
|55|	H|	Ph|	Tr|	0|	1|	|	0| |
|56|	&#674|	Ph|	Tr|	1|	1|	|	0|
|57|	&#620|	Al|	Lfr|	0|	1|		0|
|58|	&#622|	Al|	Lfr|	1|	1|		0|
|59|	l|	Al|	Lap|	1|	1|		0|
|60|	&#621|	Re|	Lap|	1|	1|		0|
|61|	&#654|	Pa|	Lap|	1|	1|		0|
|62|	L|	Ve|	Lap|	1|	1|		0|
|63|	&#634|	Al|	Lfl|	1|	1|		0|
|64|	i|	An|	An|	1|	0|	|	0|
|65|	y|	An|	An|	1|	0|	|	0|
|66|	&#616|	Ce|	Ce|	1|	0|		0|
|67|	&#649|	Ce|	Ce|	1|	0|		0|
|68|	&#623|	Po|	Po|	1|	0|		0|
|69|	u|	Po|	Po|	1|	0|	|	0|
|70|	e|	An|	An|	1|	0|	|	0|
|71|	&#248|	An|	An|	1|	0|		0|
|72|	&#600|	Ce|	Ce|	1|	0|		0|
|73|	&#629|	Ce|	Ce|	1|	0|		0|
|74|	&#612|	Po|	Po|	1|	0|		0|
|75|	o|	Po|	Po|	1|	0|	|	0|
|76|	&#603|	An|	An|	1|	0|		0|
|77|	&#339|	An|	An|	1|	0|		0|
|78|	&#604|	Ce|	Ce|	1|	0|		0|
|79|	&#606|	Ce|	Ce|	1|	0|		0|
|80|	&#652|	Po|	Po|	1|	0|		0|
|81|	&#596|	Po|	Po|	1|	0|		0|
|82|	&#230|	An|	An|	1|	0|		0|
|83|	&#592|	An|	An|	1|	0|		0|
|84|	a|	An|	An|	1|	0|	|	0|
|85|	&#630|	An|	An|	1|	0|		0|
|86|	ä|	Ce|	Ce|	1|	0|	|	0|
|87|	w|	Lve|Ap|	1|	1|	|	0|
|88|	&#593|	Po|	Po|	1|	0|		0|
|89|	&#594|	Po|	Po|	1|	0|		0|
|90|	[c]|	-|	-|	Null|	1|		0|
|91|	[v]|	-|	-|	Null|	0|		0|
|92|	&#695|	Lab|	Lab|	Null|	Null|		1|
|93|	&#720|	Long|	Long|	Null|	Null|		1|
|94|	&#712|	Stress|	Stress|				1|
|95|	-|	Affixe|	Affixe|				1|
|96|	&#700|	Ejective|	Ejective|				1|
|97|	&#800|	Retracte|	Retracte|				1|
|98|	c&#597|	AlPa|	Si+Af|	0|	1|	0|	0|
|99|	t&#620|	AlLa|	Af|	0|	1|	0|	0|
|100|	d&#622|	AlLa|	Af|	1|	0|	0|	0|
|101|	dz|	Al|	Si+Af|	1|	0|	0|	0|
|102|	&#238|	Falling|	Falling|				1|


### Running the tests

Feel free to explore this project, to upload new data, and to do some querys... 

## Author

* **Salgado Ximena** - *Initial work* - 

## Acknowledgements
* Vallée Nathalie for the oportunity and time spent in this project. 
* Denis Faure Vincent for teh guidance. 


 
