
|id|phoneme|lieu|mode|voisement|consonne|
|---|---|---|---|---|---|
|1	|m	|Bi	|Na	|1	|1	|
|2	|&#625|	Lde| Na|	1|	1|
|3	|n	|Al	|Na	|1	|1	|
|4	|&#627|	Re|	Na|	1|	1|
|5	|&#626|	Pa|	Na|	1|	1|
|6	|&#331|	Ve|	Na|	1|	1|
|7	|&#628|	Uv|	Na|	1|	1|

10	t	Al	Pl	0	1
9	b	Bi	Pl	1	1
8	p	Bi	Pl	0	1
11	d	Al	Pl	1	1
13	&#598	Re	Pl	1	1
12	&#648	Re	Pl	0	1
15	&#607	Pa	Pl	1	1
14	c	Pa	Pl	0	1
23	z	Al	Fr	1	1
22	s	Al	Fr	0	1
21	&#660	Gl	Pl	0	1
20	&#673	Ph	Pl	0	1
19	G	Uv	Pl	1	1
18	q	Uv	Pl	0	1
17	g	Ve	Pl	1	1
16	k	Ve	Pl	0	1
25	&#658	Poa	Fr	1	1
24	&#643	Poa	Fr	0	1
29	&#657	Pa	Fr	1	1
28	&#597	Pa	Fr	0	1
27	&#656	Re	Fr	1	1
26	&#642	Re	Fr	0	1
33	v	Lde	Fr	1	1
32	f	Lde	Fr	0	1
31	&#946	Bi	Fr	1	1
30	&#632	Bi	Fr	0	1
35	&#240	De	Fr	1	1
34	&#952	De	Fr	0	1
37	&#611	Ve	Fr	1	1
36	x	Ve	Fr	0	1
39	&#641	Uv	Fr	1	1
38	X	Uv	Fr	0	1
43	&#240	Gl	Fr	1	1
42	h	Gl	Fr	0	1
41	&#661	Ph	Fr	1	1
40	&#295	Ph	Fr	0	1
48	&#624	Ve	Ap	1	1
47	j	Pa	Ap	1	1
46	&#635	Re	Ap	1	1
45	&#633	Al	Ap	1	1
44	&#651	Lde	Ap	1	1
51	&#637	Re	Ta	1	1
50	&#638	Al	Ta	1	1
49	&#11377	Lde	Ta	1	1
56	&#674	Ph	Tr	1	1
55	H	Ph	Tr	0	1
54	R	Uv	Tr	1	1
53	r	Al	Tr	1	1
52	B	Bi	Tr	1	1
58	&#622	Al	Lfr	1	1
57	&#620	Al	Lfr	0	1
63	&#634	Al	Lfl	1	1
62	L	Ve	Lap	1	1
61	&#654	Pa	Lap	1	1
60	&#621	Re	Lap	1	1
59	l	Al	Lap	1	1
70	e	An	An	1	0
69	u	Po	Po	1	0
68	&#623	Po	Po	1	0
67	&#649	Ce	Ce	1	0
66	&#616	Ce	Ce	1	0
65	y	An	An	1	0
64	i	An	An	1	0
75	o	Po	Po	1	0
74	&#612	Po	Po	1	0
73	&#629	Ce	Ce	1	0
72	&#600	Ce	Ce	1	0
71	&#248	An	An	1	0
81	&#596	Po	Po	1	0
80	&#652	Po	Po	1	0
79	&#606	Ce	Ce	1	0
78	&#604	Ce	Ce	1	0
77	&#339	An	An	1	0
76	&#603	An	An	1	0
89	&#594	Po	Po	1	0
88	&#593	Po	Po	1	0
87	-	Ce	Ce	1	0
86	ä	Ce	Ce	1	0
85	&#630	An	An	1	0
84	a	An	An	1	0
83	&#592	An	An	1	0
82	&#230	An	An	1	0
90	[c]	-	-	Null	1
91	[v]	-	-	Null	0

```
Codigo ascii : 
ɳ=&#627
ɱ=&#625
ŋ=&#331
ɴ = &#628
ʈ=&#648
ɖ=    &#598
ɟ=&#607
ʡ=&#673
ʒ=&#658
ʂ=&#642
ʐ=&#656
ɕ=&#597
ʑ=&#657
ɸ=&#632
β=&#946
θ=&#952
ð=&#240
ʁ=&#641
ħ=&#295
ʕ=&#661
ɦ=&#614
ð=&#240
ʋ=&#651
ɹ=&#633
ɻ=&#635
ɰ=&#624
ɾ=&#638
ɽ=&#637
ⱱ=&#11377
ʢ=&#674
ɭ=&#621
ʎ=&#654
ɺ=&#634
ɨ=&#616
ʉ=&#649
ɯ=&#623
ø=&#248
ɘ=&#600;
ɵ=&#629
ɤ=    &#612
ɛ=    &#603
œ=&#339
ɜ=&#604
ɞ=&#606
ʌ    &#652
ɔ=&#596
æ=&#230
ɐ=    &#592

ɣ=&#611
ħ=&#295
ʷ=&#695;
ːːːː = &#720
ɬ=&#620
∫=&#643
ʕ=&#661
ŋ=&#331
ɕ=&#597
î = &#238
ɮ=&#622
ʔ=&#660;
ɲ=&#626
 ̆  = &#774
  ̠=&#800

```

```
$query = SELECT MAX(lexeme_id) FROM Lexeme 
			WHERE (langue_id = (SELECT Langue 
							  WHERE (langue_nom = afroasiatique)));
```

-voyelle longue ? 
-effet de consonne 
-# de mots/Uphones 
-derniere sylabe du mot 
-pos consonne voisé/!voisé 
 
