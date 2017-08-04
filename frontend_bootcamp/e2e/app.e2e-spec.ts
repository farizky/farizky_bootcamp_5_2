import { FrontendBootstrapPage } from './app.po';

describe('frontend-bootstrap App', () => {
  let page: FrontendBootstrapPage;

  beforeEach(() => {
    page = new FrontendBootstrapPage();
  });

  it('should display welcome message', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('Welcome to app!');
  });
});
