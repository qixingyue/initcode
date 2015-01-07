
command -nargs=0 Newphp :call Newphp()
au BufNewFile *.php :Newphp
function Newphp()
	let curdir = getcwd()
	call setline(1,"")
	"echo bufname("%")
	"echo join([".!php ", " --ini", bufname("%"), " ",curdir])
	execute join([".!", "/users/xingyue/initcode/tool.php ",curdir," ",bufname("%") ])
endf
