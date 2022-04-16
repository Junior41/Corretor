#ifndef _NO_H
#define _NO_H

typedef struct no{
    int terminal;
    struct no **filhos;
}No;

No *criaNo(int);


void desalocaNo(No *);

void desalocaNos(No *, int);

#endif