CFLAGS=-O0 -std=c11 -Wall -Werror -Wextra -Wno-sign-compare -Wno-unused-parameter -Wno-unused-variable -Wshadow
LIBS=-lm
EXECUTAVEL=arvoreTrie

all: $(EXECUTAVEL)

$(EXECUTAVEL): no.o arvore.o cliente.o
	gcc no.o arvore.o cliente.o  $(LIBS) -o $(EXECUTAVEL)

arvore.o: arvore.c
	gcc $(CFLAGS) -c arvore.c

no.o: no.c
	gcc $(CFLAGS) -c no.c

cliente.o: cliente.c
	gcc $(CFLAGS) -c cliente.c

clean:
	rm -rf *.o $(EXECUTAVEL)

memcheck: $(EXECUTAVEL)
	valgrind --tool=memcheck --leak-check=full ./$(EXECUTAVEL)

run: $(EXECUTAVEL)
	./$(EXECUTAVEL)