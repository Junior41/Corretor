#ifndef _ARVORE_H
#define _ARVORE_H
#include "no.h"

typedef struct arvore{
    No *raiz;
    char *alfabeto;
    int quantidadeElementos;
}Arvore;

Arvore* criaArvore();

void desalocaArvore(Arvore *arv);

No* buscaDigital(Arvore *, No *, char [], int *, int *);

int insere(Arvore *, char[]);

int vazia(Arvore *);

void remover(Arvore *, char *);

int buscaPosicaoDicionario(char[], char, int, int);

#endif