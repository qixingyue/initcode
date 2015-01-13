
command -nargs=0 Newcode :call Newcode()

"可以适度的对*.*进行更改
au BufNewFile *.* :Newcode

function Newcode()
	let curdir = getcwd()
	call setline(1,"")

	"其中tool.php 为可执行文件，按实际情况修改
	execute join([".!", "/users/xingyue/initcode/tool.php ",curdir," ",bufname("%") ])
endf
