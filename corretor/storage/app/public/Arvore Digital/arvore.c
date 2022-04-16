#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>
#include "arvore.h"


Arvore* criaArvore(char alfabeto[]){
    Arvore *arv = malloc(sizeof(Arvore));

    arv->raiz = criaNo(strlen(alfabeto));
    arv->quantidadeElementos = 0;
    arv->alfabeto = malloc((strlen(alfabeto) + 1) * sizeof(char));
    strcpy(arv->alfabeto, alfabeto);

    free(alfabeto);

    return arv;
}


int buscaPosicaoDicionario(char alfabeto[], char caracter, int inicio, int fim){
    int meio = (inicio + fim) / 2;
    if(inicio >= fim)
        return -1;
    if(alfabeto[meio] == caracter)
        return meio;
    if(alfabeto[meio] > caracter)
        return buscaPosicaoDicionario(alfabeto, caracter, inicio, meio);
    else
        return buscaPosicaoDicionario(alfabeto, caracter, meio + 1, fim);
}

int vazia(Arvore *arv){
    return arv->quantidadeElementos == 0;
}


No* buscaDigital(Arvore *arv, No *raiz, char valor[], int *indiceValor, int *encontrado){

    if(valor[*indiceValor] == -61)
        (*indiceValor)++;

    char c = '0';
    if(*indiceValor < strlen(valor)){ // percorrendo cada caracter do valor buscado

        // garantindo que o caracter é minúsculo
        c = valor[*indiceValor];
        c = tolower(c);

        if(c < -97)
            c+= 32;

        int posicaoAlfabeto = buscaPosicaoDicionario(arv->alfabeto, c, 0, strlen(arv->alfabeto));

        if(raiz->filhos[posicaoAlfabeto]){
            (*indiceValor)++;
            return buscaDigital(arv, raiz->filhos[posicaoAlfabeto], valor, indiceValor, encontrado);
        }
    }else if(raiz->terminal)
        *encontrado = 1;

    return raiz;

}

/*
    Retorna 1 se todos os caracteres de "valor" estão no dicionário.
*/
int verificaCaracteres(Arvore *arv, char *valor){
    int posicaoAlfabeto = 0;

    for(int i = 0; i < strlen(valor); i++){
        if(valor[i] != -61){
            posicaoAlfabeto = buscaPosicaoDicionario(arv->alfabeto, valor[i], 0, strlen(arv->alfabeto));

            if(posicaoAlfabeto == -1)
                return 0;
        }
    }

    return 1;
}


int insere(Arvore *arv, char valor[]){
    No *auxiliar1 = NULL;
    int indiceValor = 0, encontrado = 0, posicaoAlfabeto = 0, sucesso = 0;

    if(!verificaCaracteres(arv, valor)){
        free(valor);
        return sucesso;
    }


    auxiliar1 = buscaDigital(arv, arv->raiz, valor, &indiceValor, &encontrado);

    if(!encontrado){

        for(int percorreValor = indiceValor; percorreValor < strlen(valor); percorreValor++){
            if(valor[percorreValor] != -61){
                posicaoAlfabeto = buscaPosicaoDicionario(arv->alfabeto, valor[percorreValor], 0, strlen(arv->alfabeto));
                auxiliar1->filhos[posicaoAlfabeto] = criaNo(strlen(arv->alfabeto));

                auxiliar1 = auxiliar1->filhos[posicaoAlfabeto];
            }
        }

        auxiliar1->terminal = 1;
        arv->quantidadeElementos++;
        sucesso = 1;
    }else
        sucesso = 0;

    free(valor);

    return sucesso;
}

void desalocaArvore(Arvore *arv){
    if(arv){
        if(arv->raiz)
            desalocaNos(arv->raiz, strlen(arv->alfabeto));

        free(arv->alfabeto);
        free(arv);
    }
}